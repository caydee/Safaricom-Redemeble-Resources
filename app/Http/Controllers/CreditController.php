<?php

namespace App\Http\Controllers;


use App\Models\OrgUnits as Unit;
use Illuminate\Http\Request;

class CreditController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function index()
            {
                return view('modules.credits.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function create()
            {
                return view('modules.credits.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
            {
                //
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function show($id)
            {
                $this->data['credit']   =   Unit::find($id);
                return view('modules.credits.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function edit($id)
            {
                $this->data['credit']   =   Unit::find($id);
                return view('modules.credits.edit',$this->data);
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
                $columns        =   array( 0 => 'id' , 1 => 'organization_id' , 2 => 'product_id' , 3 => 'units');
                $totalData      =   Unit::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                    $posts = Unit::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                    }
                else
                    {

                    $search         =   $request->input('search.value');
                    $posts          =   Unit::WhereHas('product',function($query) use($search){
                        $query->where('name','LIKE',"%{$search}%");
                    })
                        ->orWhereHas('organization',function($query) use($search){
                            $query->where('name','LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

                    $totalFiltered  =    Unit::WhereHas('product',function($query) use($search){
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
                        $nestedData['product']      =   $post->product->name;
                        $nestedData['units']        =   $post->units;
                        $nestedData['action']       =   '<a href="'.route('product.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>'.$actionbtn;
                        $data[]                     =   $nestedData;

                        }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
