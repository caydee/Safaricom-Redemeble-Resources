<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProduct;
use App\Http\Requests\EditProduct;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function index()
            {
                return view('modules.product.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function create()
            {
                $this->data['product_type'] =   ProductType::where('product_type_status',1)->get();
                return view('modules.product.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\CodeIgniter\HTTP\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|void
         */
        public function store(AddProduct $request)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $product                    =   new Product();
                        $product->name              =   $request->name;
                        $product->sender_name       =   $request->sender_name;
                        $product->product_type_id   =   $request->product_type;
                        $product->status            =   1;
                        $res                        =   $product->save();
                        if($res)
                            return self::success('Product','Added successfully',route('product.index'));
                        return self::fail('Product','Failed to add',route('product.index'));
                    }
                return self::fail('Product',$validateddata,route('product.index'));
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function show($id)
            {
                $this->data['product']  =   Product::find($id);
                return view('modules.product.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function edit($id)
            {
                $this->data['product']      =   Product::find($id);
                $this->data['product_type'] =   ProductType::where('product_type_status',1)->get();
                return view('modules.product.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         *
         * @return array|\CodeIgniter\HTTP\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|void
         */
        public function update(EditProduct $request, $id)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $product                    =   Product::find($id);
                        $product->name              =   $request->name;
                        $product->sender_name       =   $request->sender_name;
                        $product->status            =   1;
                        $product->product_type_id   =   $request->product_type;
                        $res                        =   $product->save();
                        if($res)
                            return self::success('Product','Added successfully',route('product.index'));
                        return self::fail('Product','Failed to add',route('product.index'));
                    }
                return self::fail('Product',$validateddata,route('product.index'));
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
                $columns        =   array( 0 => 'id' , 1 => 'name' , 2 => 'sender_name' , 3 => 'product_type_id');
                $totalData      =   Product::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                    $posts = Product::offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                    }
                else
                    {

                    $search         =   $request->input('search.value');
                    $posts          =   Product::where('name','LIKE',"%{$search}%")
                                                ->orWhereHas('product',function($query) use($search){
                                                        $query->where('product_type','LIKE',"%{$search}%");
                                                    })
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                    $totalFiltered  =   Product::where('name','LIKE',"%{$search}%")
                                                ->orWhereHas('product',function($query) use($search){
                                                        $query->where('product_type','LIKE',"%{$search}%");
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
                        $nestedData['pos']      =   $pos;
                        $nestedData['name']     =   $post->name;
                        $nestedData['type']     =   $post->type->product_type;
                        $nestedData['para']     =   $post->sender_name;
                        $nestedData['status']   =   ($post->status === 1)?'Active':'Inactive';
                        $nestedData['action']   =   '<a href="'.route('product.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>'.$actionbtn;
                        $data[]                 =   $nestedData;

                        }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
