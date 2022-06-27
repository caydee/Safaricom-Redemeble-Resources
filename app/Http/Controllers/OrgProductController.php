<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrgProduct;
use App\Models\AccessType;
use App\Models\OrgProduct;
use App\Models\Organization;
use App\Models\Product;
use Illuminate\Http\Request;

class OrgProductController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index($orgid)
            {
                $this->data['org']  =   Organization::find($orgid);
                return view('modules.orgproduct.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function create($orgid)
            {
                $this->data['product']  =   Product::where('status',1)->get();
                $this->data['access']   =   AccessType::where('access_status',1)->get();
                $this->data['org']      =   Organization::find($orgid);
                return view('modules.orgproduct.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\Illuminate\Http\Response
         */
        public function store(AddOrgProduct $request,$orgid)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $orgprod                    =   new OrgProduct();
                        $orgprod->product_id        =   $request->product;
                        $orgprod->access_type_id    =   $request->access;
                        $orgprod->organization_id   =   $orgid;
                        $res                        =   $orgprod->save();
                        if($res)
                            return self::success('Assign product','Success',route('organization.product.index',$orgid));
                        return self::fail('Assign product','Fail',route('organization.product.index',$orgid));
                    }
                return self::fail('Assign product',$validateddata,route('organization.product.index',$orgid));

            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function show($orgid,$id)
            {
                $this->data['org']          =   Organization::find($orgid);
                $this->data['orgproduct']   =   Product::find($id);
                return view('modules.orgproduct.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit($orgid,$id)
            {
                $this->data['org']          =   Organization::find($orgid);
                $this->data['orgproduct']   =   OrgProduct::find($id);
                return view('modules.orgproduct.view',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         *
         * @return array
         */
        public function update(Request $request,$orgid, $id)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $orgprod                    =   OrgProduct::find($id);
                        $orgprod->product_id        =   $request->product;
                        $orgprod->access_type_id    =   $request->access;
                        $orgprod->organization_id   =   $orgid;
                        $res                        =   $orgprod->save();
                        if($res)
                            return self::success('Assign product','Success',route('organization.product.index',$orgid));
                        return self::fail('Assign product','Fail',route('organization.product.index',$orgid));
                    }
                return self::fail('Assign product',$validateddata,route('organization.product.index',$orgid));
            }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($orgid,$id)
            {
                //
            }
        public function check($orgid)
            {
                $data   =   OrgProduct::with('product')->where('organization_id',$orgid)
                                        ->get();
                return response()->json($data);
            }
        public function get(Request $request,$orgid)
            {
                $columns        =   array( 0 => 'id' , 1 => 'product_id' , 2 => 'access_id' );
                $totalData      =   OrgProduct::where('organization_id',$orgid)
                                                ->count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts =  OrgProduct::where('organization_id',$orgid)
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   OrgProduct::where('organization_id',$orgid)
                                                        ->orWhereHas('access',function($query) use($search){
                                                                $query->where('access_name','LIKE',"%{$search}%");
                                                            })
                                                        ->orWhereHas('product',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                        ->offset($start)
                                                        ->limit($limit)
                                                        ->orderBy($order,$dir)
                                                        ->get();

                        $totalFiltered  =   OrgProduct::where('organization_id',$orgid)
                                                        ->orWhereHas('access',function($query) use($search){
                                                                $query->where('access_name','LIKE',"%{$search}%");
                                                            })
                                                        ->orWhereHas('product',function($query) use($search){
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
                            $actionbtn              =   (   $post->status == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                            $nestedData['pos']      =   $pos;
                            $nestedData['product']  =   $post->product->name;
                            $nestedData['access']   =   $post->access_type->name;
                            $nestedData['units']    =   $post->produnits($orgid,$post->product->id)->units??0;
                            $nestedData['action']   =   '<div class="d-flex justify-content-between"></div><a href="'.route
                                ('organization.edit',
                                    $post->id)
                                .'"  class="text-dark mr-1" ><i class="fas fa-edit  "></i></a>
                                                                                            '.$actionbtn.'</div>';

                            $data[]                 =   $nestedData;
                            $pos++;
                        }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
