<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUser;
use App\Http\Requests\EditUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.users.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                $this->data['role'] =   Role::get();
                return view('modules.users.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\CodeIgniter\HTTP\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|void
         */
        public function store(AddUser $request)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {

                        $user           =   new User();
                        $user->email    =   strtolower($request->email);
                        $user->name     =   $request->name;
                        $user->password =   Hash::make($request->password);
                        $user->status   =   1;
                        $user->role_id  =   $request->role;
                        $usr            =   $user->save();
                        if($usr)
                            {
                            return self::success('User','Added user successfully',url('backend/user'));
                            }
                        return self::fail('User','Failed to add user',url('backend/user'));
                    }
                return self::fail('User',$validateddata,url('backend/user'));

            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
            {

            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit($id)
            {
                $this->data['user'] =   User::find($id);
                $this->data['role'] =   Role::get();
                return view('modules.users.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(EditUser $request, $id)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {

                        $user           =   User::find($id);
                        $user->email    =   strtolower($request->email);
                        $user->name     =   $request->name;
                        $user->password =   Hash::make($request->password);
                        $user->status   =   $request->status??0;
                        $user->role_id  =   $request->role;
                        $usr            =   $user->save();
                        if($usr)
                            {
                                return self::success('User','Updated user successfully',url('backend/user'));
                            }
                        return self::fail('User','Failed to update user',url('backend/user'));
                    }
                return self::fail('User',$validateddata,url('backend/user'));
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
                $columns        =   array( 0 => 'id' , 1 => 'name' , 2 => 'email' , 3 => 'status' , 4 => 'role' );
                $totalData      =   User::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = User::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   User::where('name','LIKE',"%{$search}%")
                                                ->orWhere('email', 'LIKE',"%{$search}%")
                                                ->orWhere('status', 'LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                        $totalFiltered  =   User::where('name','LIKE',"%{$search}%")
                                                ->orWhere('email', 'LIKE',"%{$search}%")
                                                ->orWhere('status', 'LIKE',"%{$search}%")
                                                ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        foreach ($posts as $post)
                            {
                                $actionbtn              =   (   $post->status == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":
                                    "<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                                $nestedData['id']       =   $post->id;
                                $nestedData['name']     =   $post->name;
                                $nestedData['email']    =   $post->email;
                                $nestedData['status']   =   ($post->status == 1)?'Active':"inactive";
                                $nestedData['role']     =   is_numeric($post->role_id)?Role::where("id",$post->role_id)->first()->name:NULL;
                                $nestedData['action']   =   '<a href="'.url('backend/user/'.$post->id.'/edit').'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>
                                                                            '.$actionbtn;

                                $data[]                 =   $nestedData;

                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }



    }
