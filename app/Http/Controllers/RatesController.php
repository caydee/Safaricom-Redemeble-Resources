<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRate;
use App\Http\Requests\EditRate;
use App\Models\Organization;
use App\Models\Rate;
use Illuminate\Http\Request;

class RatesController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function index()
            {
                return view('modules.rates.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function create()
            {
                $this->data['organization']     =   Organization::where('status','1')->get();
                return view('modules.rates.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\CodeIgniter\HTTP\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|void
         */
        public function store(AddRate $request)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $rate                   =   new Rate();
                        $rate->product_id       =   $request->product;
                        $rate->organization_id  =   $request->organization;
                        $rate->min_value        =   $request->min_val;
                        $rate->max_value        =   $request->max_val;
                        $rate->unit_cost        =   $request->unit_cost;
                        $rate->status           =   1;
                        $res                    =   $rate->save();
                        if($res)
                            return self::success('rate','success',route('rates.index'));
                    return self::fail('rate','fail',route('rates.index'));
                    }
                return self::fail('Rate',$validateddata,url('backend/rates'));
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function show($id)
            {
                $this->data['rates']    =   Rate::find($id);
                return view('modules.rates.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function edit($id)
            {
                $this->data['organization']     =   Organization::where('status','1')->get();
                $this->data['rates']            =   Rate::find($id);
                return view('modules.rates.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         *
         * @return array|\CodeIgniter\HTTP\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|void
         */
        public function update(EditRate $request, $id)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                    $rate                   =   new Rate();
                    $rate->product_id       =   $request->product;
                    $rate->organization_id  =   $request->organization;
                    $rate->min_value        =   $request->min_val;
                    $rate->max_value        =   $request->max_val;
                    $rate->unit_cost        =   $request->unit_cost;
                    $res                    =   $rate->save();
                    if($res)
                            return self::success('rate','success',route('rates.index'));
                        return self::fail('rate','fail',route('rates.index'));
                    }
                return self::fail('Rate',$validateddata,url('backend/rates'));
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
                $columns        =   array( 0 => 'id' , 1 => 'product_id', 2=>'organization_id',3=>'min_value',4=>'max_value',5=>'unit_cost');
                $totalData      =   Rate::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Rate::offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                    }
                else
                    {
                        $search         =   $request->input('search.value');


                        $posts          =   Rate::where('min_value','like',"%{$search}%")
                                                ->orWhere('max_value','like',"%{$search}%")
                                                ->orWhere('min_value','like',"%{$search}%")
                                                ->orWhereHas('organization',function($query) use($search){
                                                        $query->where('name','like',"%{$search}%");
                                                    })
                                                ->orWhereHas('product',function($query) use($search){
                                                        $query->where('name','like',"%{$search}%");
                                                    })
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                        $totalFiltered  =  Rate::where('min_value','like',"%{$search}%")
                                                ->orWhere('max_value','like',"%{$search}%")
                                                ->orWhere('min_value','like',"%{$search}%")
                                                ->orWhereHas('organization',function($query) use($search){
                                                        $query->where('name','like',"%{$search}%");
                                                    })
                                                ->orWhereHas('product',function($query) use($search){
                                                        $query->where('name','like',"%{$search}%");
                                                    })
                                                ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        $x = $start+1;
                        foreach ($posts as $post)
                            {

                            $nestedData['pos']          =   $x;
                            $nestedData['product']      =   $post->product->name;
                            $nestedData['organization'] =   $post->organization->name ;
                            $nestedData['min_value']    =   $post->min_value;
                            $nestedData['max_value']    =   $post->max_value;
                            $nestedData['unit_cost']    =   $post->unit_cost;
                            $nestedData['action']       =   '<a href="'.route('rates.edit',$post->id).'" class="edit-role text-muted"><i class="fas fa-edit"></i></a>';
                            $data[]                     =   $nestedData;
                            $x++;
                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
