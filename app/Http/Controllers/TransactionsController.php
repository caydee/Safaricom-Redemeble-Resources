<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTransaction;
use App\Models\Organization;
use App\Models\Rate;
use App\Models\Transaction;
use App\Traits\Meta;
use Illuminate\Http\Request;
use \App\Models\OrgUnits;
use Illuminate\Support\Carbon;

class TransactionsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.transaction.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                $this->data['organization']     =   Organization::where('status',1)->get();
                return view('modules.transaction.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array
         */
        public function store(AddTransaction $request)
            {
                if($validateddata = $request->validated())
                    {
                        $rate                   =   Meta::rate($request->organization_id , $request->product_id , $request->amount);
                        $trans                  =   new Transaction();
                        $trans->receipt_no      =   $request->receipt;
                        $trans->amount          =   $request->amount;
                        $trans->product_id      =   $request->product_id;
                        $trans->organization_id =   $request->organization_id;
                        $trans->channel         =   $request->channel;
                        $trans->rate            =   $rate;
                        $trans->units           =   ceil($request->amount*(1/$rate));
                        $res                    =   $trans->save();
                        if ($res)
                            {


                                $check = OrgUnits::where('organization_id' , $request->organization_id)
                                                    ->where('product_id' , $request->product_id)
                                                    ->first();
                                if (is_null($check))
                                    {
                                        $res2 = OrgUnits::insert([ 'organization_id' => $request->organization_id , 'product_id' => $request->product_id , 'units' => ceil((1/$rate) * $request->amount) ]);
                                    }
                                else
                                    {
                                        $check->increment('units' , ceil((1/$rate) * $request->amount));
                                        $res2 = $check->save();
                                    }
                                if($res2)
                                    return self::success('Units' , 'Added successfully' , route('credits.index'));
                                return self::fail('Units' , 'Failed to add' , route('credits.index'));

                            }
                    }
                return self::fail('Units',$validateddata,route('credits.index'));
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function show($id)
            {
                $this->data['organization'] =   Organization::where('status',1)->get();
                $this->data['transaction']  =   Transaction::find($id);
                return view('modules.transaction.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function edit($id)
            {
                $this->data['transaction']  =   Transaction::find($id);
                return view('modules.transaction.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
            {
                //
            }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
            {
                //
            }
        public function get(Request $request)
            {
                $columns        = array( 0 => 'id' , 1 => 'receipt_no' , 2 => 'organization_id' , 3 => 'channel' , 4
                => 'amount' , 5 => 'rate' , 6 => 'units', 7 => 'created_at' );
                $totalData      =   Transaction::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = Transaction::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   Transaction::where('receipt_no','LIKE',"%{$search}%")
                                                        ->orWhere('channel','LIKE',"%{$search}%")
                                                        ->orWhereHas('product',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                        ->orWhereHas('organization',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                        ->offset($start)
                                                        ->limit($limit)
                                                        ->orderBy($order,$dir)
                                                        ->get();

                        $totalFiltered  =   Transaction::where('receipt_no','LIKE',"%{$search}%")
                                                        ->orWhere('channel','LIKE',"%{$search}%")
                                                        ->orWhereHas('product',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                        ->orWhereHas('organization',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                        ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                    $pos    =   $start+1;
                    foreach ($posts as $post)
                        {
                            $actionbtn                          =   (   $post->status == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":
                                "<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                            $nestedData['pos']          =   $pos;
                            $nestedData['organization'] =   $post->organization->name;
                            $nestedData['receipt']      =   $post->receipt_no;
                            $nestedData['channel']      =   $post->channel;
                            $nestedData['amount']       =   $post->amount;
                            $nestedData['rate']         =   $post->rate;
                            $nestedData['units']        =   $post->units;
                            $nestedData['time']         =   Carbon::parse($post->created_at)->format('h:ia d M Y');
                            $nestedData['action']       =   '<a href="'.route('transaction.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>'.$actionbtn;
                            $data[]                     =   $nestedData;
                            $pos++;
                        }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
