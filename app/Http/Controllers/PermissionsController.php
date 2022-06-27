<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Utils\Sdata;
use Illuminate\Http\Request;

class PermissionsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.permissions.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                return view('modules.permissions.add',$this->data);
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
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function show($id)
            {
                return view('modules.permissions.view',$this->data);
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
                return view('modules.permissions.edit',$this->data);
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
                $columns        =   array( 0 => 'id' , 1 => 'name' , 2 => 'action' );
                $totalData      =   Permission::whereNotNull("name")
                                                ->count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Permission::whereNotNull("name")
                                            ->offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();
                    }
                else
                    {
                        $search         =   $request->input('search.value');


                        $posts          =   Permission::whereNotNull("name")
                                                    ->where('name','like',"%{$search}%")
                                                    ->offset($start)
                                                    ->limit($limit)
                                                    ->orderBy($order,$dir)
                                                    ->get();

                        $totalFiltered  =  Permission::whereNotNull("name")
                                                    ->where('name','like',"%{$search}%")
                                                    ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        $x = $start+1;
                        foreach ($posts as $post)
                            {
                                $nestedData['pos']          =   $x;
                                $nestedData['name']         =   $post->name;
                                $nestedData['access']       =   $post->action;
                                $nestedData['roles']        =   Sdata::getaccess($post->id);
                                $nestedData['action']       =   '<a href="javascript:;"  class="text-dark mr-3 edit-permission" data-user="'.$post->id.'"><i class="fas fa-edit  "></i></a>
                                                                                <a href="javascript:;"  class="text-dark mr-3 assign-role" data-user="'.$post->id.'"><i class="fas fa-plus-circle  "></i></a>' ;
                                $data[]                     =   $nestedData;
                                $x++;
                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                echo json_encode($json_data);
            }
    }
