<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAccessType;
use App\Http\Requests\EditAccessType;
use App\Models\AccessType;
use Illuminate\Http\Request;

class AccessTypeController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.access_type.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                return view('modules.access_type.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\Illuminate\Http\Response
         */
        public function store(AddAccessType $request)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                        $accesstype                     =   new AccessType();
                        $accesstype->access_name        =   $request->access_type_name;
                        $accesstype->access_description =   $request->access_type_description;
                        $accesstype->access_status      =   $request->active??0;
                        $res                            =   $accesstype->save();
                        if($res)
                            return self::success('Access Type','Added successfully',url('backend/access-type'));
                        return self::fail('Access Type','Failed to add',url('backend/access-type'));
                    }
                return self::fail('Access Type',$validateddata,url('backend/access-type'));
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
                $this->data['access_type']  =   AccessType::find($id);
                return view('modules.access_type.view',$this->data);
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
                $this->data['accesstype']  =   AccessType::find($id);
                return view('modules.access_type.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         *
         * @return array|\Illuminate\Http\Response
         */
        public function update(EditAccessType $request, $id)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {
                    $accesstype                     =   AccessType::find($id);
                    $accesstype->access_name        =   $request->access_type_name;
                    $accesstype->access_description =   $request->access_type_description;
                    $accesstype->access_status      =   $request->active??0;
                    $res                            =   $accesstype->save();
                    if($res)
                        return self::success('Access Type','Added successfully',url('backend/access-type'));
                    return self::fail('Access Type','Failed to add',url('backend/access-type'));
                    }
                return self::fail('Access Type',$validateddata,url('backend/access-type'));
            }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
            {

            }
        public function get(Request $request)
            {
                $columns        =   array( 0 => 'id' , 1 => 'access_name' , 2 => 'access_description' , 3 => 'status');
                $totalData      =   AccessType::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = AccessType::offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();
                    }
                else
                    {

                    $search         =   $request->input('search.value');
                    $posts          =   AccessType::where('access_name','LIKE',"%{$search}%")
                                                    ->orWhere('access_description','LIKE',"%{$search}%")
                                                    ->offset($start)
                                                    ->limit($limit)
                                                    ->orderBy($order,$dir)
                                                    ->get();

                    $totalFiltered  =   AccessType::where('access_name','LIKE',"%{$search}%")
                                                    ->orWhere('access_description','LIKE',"%{$search}%")
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
                                $nestedData['pos']                  =   $pos;
                                $nestedData['access_type']          =   $post->access_name;
                                $nestedData['access_description']   =   $post->access_description;
                                $nestedData['status']               =   ($post->access_status == 1)?'Active':"inactive";
                                $nestedData['action']               =   '<a href="'.route('access_type.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>
                                                                                                '.$actionbtn;
                                $data[]                             =   $nestedData;

                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
