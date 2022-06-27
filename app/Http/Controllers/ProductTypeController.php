<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductType;
use App\Http\Requests\EditProductType;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.product_type.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                return view('modules.product_type.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\Illuminate\Http\Response
         */
        public function store(AddProductType $request)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $producttype                            =   new ProductType();
                        $producttype->product_type              =   $request->product_type;
                        $producttype->product_type_description  =   $request->product_description;
                        $producttype->product_type_status       =   $request->active??0;
                        $res                                    =   $producttype->save();
                        if($res)
                            return self::success('Product Type','Added successfully',url('backend/product-type'));
                    return self::fail('Product Type','Failed to add',url('backend/product-type'));
                    }
                return self::fail('Product Type',$validateddata,url('backend/product-type'));

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
                $this->data['product_type'] =   ProductType::find($id);
                return view('modules.product_type.view',$this->data);
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
                $this->data['producttype'] =   ProductType::find($id);
                return view('modules.product_type.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         *
         * @return array
         */
        public function update(EditProductType $request, $id)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                    $producttype                            =   ProductType::find($id);
                    $producttype->product_type              =   $request->product_type;
                    $producttype->product_type_description  =   $request->product_description;
                    $producttype->product_type_status       =   $request->active??0;
                    $res                                    =   $producttype->save();
                    if($res)
                        return self::success('Product Type','Updated successfully',url('backend/product-type'));
                    return self::fail('Product Type','Failed to update',url('backend/product-type'));
                    }
                return self::fail('Product Type',$validateddata,url('backend/product-type'));
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
                $columns        =   array( 0 => 'id' , 1 => 'product_type' , 2 => 'product_type_description' , 3 => 'product_type_status');
                $totalData      =   ProductType::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = ProductType::offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();
                    }
                else
                    {

                    $search         =   $request->input('search.value');
                    $posts          =   ProductType::where('product_type','LIKE',"%{$search}%")
                                                ->orWhere('product_type_description','LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                    $totalFiltered  =   ProductType::where('product_type','LIKE',"%{$search}%")
                                                    ->orWhere('product_type_description','LIKE',"%{$search}%")
                                                    ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        $pos    =   $start+1;
                        foreach ($posts as $post)
                            {
                            $actionbtn                             =   (   $post->status == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                            $nestedData['pos']                     =   $pos;
                            $nestedData['product_type']            =   $post->product_type;
                            $nestedData['product_description']     =   $post->product_type_description;
                            $nestedData['status']                  =   ($post->product_type_status == 1)?'Active':"inactive";
                            $nestedData['action']                  =   '<a href="'.route('product_type.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>'.$actionbtn;
                            $data[]                                =   $nestedData;

                        }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
