<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRole;
use App\Http\Requests\EditRole;
use App\Models\Permission;
use App\Models\Permission_Role;
use App\Models\Role;
use App\Utils\Sdata;
use Illuminate\Http\Request;

class RolesController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index($user_id)
            {
                return view('modules.roles.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                $this->data['perm'] =   Permission::whereNotNull("name")->orderBy('name','asc')->get();
                return view('modules.roles.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\Illuminate\Http\Response
         */
        public function store(AddRole $request)
            {
                $validateddata = $request->validated();
                if($validateddata)
                    {
                        $role           =   new Role();
                        $role->name     =   $request->role;
                        $req            =   $role->save();
                        if($req)
                            {
                            if(isset($request->perm))
                                {

                                    foreach($request->perm as $value)
                                        {
                                            $pr                 =  new Permission_Role();
                                            $pr->role_id        =   $role->id;
                                            $pr->permission_id  =   $value;
                                            $pr->save();
                                        }
                                }

                            return array('status'=>TRUE,'msg'=>'Role saved successfully','header'=>'Role');
                            }

                            return array('status'=>FALSE,'msg'=>"Role not saved",'header'=>'Role');

                    }

                    return array('status'=>FALSE,'msg'=>$validateddata,'header'=>'Role');

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
                $this->data['role'] = Role::find($id);
                return view('modules.roles.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit($id)
            {
                $this->data['role'] =   Role::find($id);
                $this->data['perm'] =   Permission::whereNotNull("name")->orderBy('name','asc')->get();
                return view('modules.roles.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         *
         * @return array|\Illuminate\Http\Response
         */
        public function update(EditRole $request, $id)
            {

                $validateddata = $request->validated();
                if($validateddata)
                    {
                        $role           =   Role::find($id);
                        $role->name     =   $request->role;
                        $req            =   $role->save();
                        if($req)
                            {
                            if(isset($request->perm))
                                {
                                    Permission_Role::where('role_id',$id)
                                        ->delete();
                                    foreach($request->perm as $value)
                                        {
                                            $pr                 =   new Permission_Role();
                                            $pr->role_id        =   $request->id;
                                            $pr->permission_id  =   $value;
                                            $pr->save();
                                        }
                                }

                                return array('status'=>TRUE,'msg'=>'Role saved successfully','header'=>'Role');
                            }
                            return array('status'=>FALSE,'msg'=>"Role not saved",'header'=>'Role');
                        }
                    return array('status'=>FALSE,'msg'=>$validateddata,'header'=>'Role');
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
        public function get(Request $request, $user_id)
            {
                $columns        =   array( 0 => 'id' , 1 => 'name' );
                $totalData      =   Role::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Role::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {
                        $search         =   $request->input('search.value');


                        $posts          =   Role::where('name','like',"%{$search}%")
                                                    ->offset($start)
                                                    ->limit($limit)
                                                    ->orderBy($order,$dir)
                                                    ->get();

                        $totalFiltered  =  Role::where('name','like',"%{$search}%")
                                        ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        $x = $start+1;
                        foreach ($posts as $post)
                            {
                                $perm                       =   array_column(Permission_Role::where('role_id',$post->id)->get()->toArray(),'permission_id');
                                $nestedData['pos']          =   $x;
                                $nestedData['name']         =   $post->name;
                                $nestedData['access']       =   Sdata::getperm($post->id) ;
                                $nestedData['action']       =   '<a href="'.route('user.role.edit',
                                        [$user_id??0,$post->id])
                                    .'" class="edit-role text-muted"><i class="fas fa-edit"></i></a>';
                                $data[]                     =   $nestedData;
                                $x++;
                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
