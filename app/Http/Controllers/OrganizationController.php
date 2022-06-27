<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrganization;
use App\Http\Requests\EditOrganization;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function index()
            {
                return view('modules.organization.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function create()
            {
                return view('modules.organization.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Http\Response
         */
        public function store(AddOrganization $request)
            {
                $validateddata = $request->validated();
                if($validateddata)
                    {
                        $user                       =   User::updateOrCreate(['email'=>$request->admin_email],
                            ['name'=>$request->admin_name,'phone_no'=>$request->phone,'password'=>bcrypt
                            ($request->password),'organization_id'=>0,'status'=>1]);
                        $organization               =   new Organization();
                        $organization->name         =   $request->organization_name;
                        $organization->parent_id    =   Auth::user()->organization_id;
                        $organization->user_id      =   $user->id;
                        $organization->status       =   1;
                        $res                        =   $organization->save();
                        $user->organization_id      =   $organization->id;
                        $user->save();
                        if($res)
                            return self::success('Organization','Created Successfully',url('backend/organization'));
                        return self::fail('Organization','Creation Failed',url('backend/organization'));
                    }
                return self::fail('Organization',$validateddata,url('backend/organization'));
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function show($id)
            {
                $this->data['organization'] =   Organization::find($id);
                return view('modules.organization.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
         */
        public function edit($organization)
            {
                $this->data['organization'] =   Organization::find($organization);
                return view('modules.organization.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return array|\Illuminate\Http\Response
         */
        public function update(EditOrganization $request, $id)
            {
                $validateddata = $request->validated();
                if($validateddata)
                    {
                        $data                       =   ['name'=>$request->admin_name,'phone_no'=>$request->phone,'organization_id'=>0,'status'=>1];
                        if($request->has('password'))
                            $data['password']       =   bcrypt($request->password);
                        $user                       =   User::updateOrCreate(['email'=>$request->admin_email],$data);
                        $organization               =   Organization::find($id);
                        $organization->name         =   $request->organization_name;
                        $organization->user_id      =   $user->id;
                        $organization->status       =   1;
                        $res                        =   $organization->save();
                        $user->organization_id      =   $organization->id;
                        $user->save();
                        if($res)
                            return self::success('Organization','Created Successfully',url('backend/organization'));
                        return self::fail('Organization','Creation Failed',url('backend/organization'));
                    }
                return self::fail('Organization',$validateddata,url('backend/organization'));
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
                $columns        =   array( 0 => 'id' , 1 => 'name' , 2 => 'parent_id' , 3 => 'status' , 4 => 'user_id', 5 => 'user_id', 6 => 'user_id' );
                $totalData      =   Organization::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = Organization::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   Organization::where('name','LIKE',"%{$search}%")
                                                            ->orWhereHas('parent',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                            ->orWhereHas('user',function($query) use($search){
                                                                        $query->where('name','LIKE',"%{$search}%")
                                                                            ->orWhere('email', 'LIKE',"%{$search}%")
                                                                            ->orWhere('phone_no', 'LIKE',"%{$search}%");
                                                                    })
                                                            ->offset($start)
                                                            ->limit($limit)
                                                            ->orderBy($order,$dir)
                                                            ->get();

                        $totalFiltered  =   Organization::where('name','LIKE',"%{$search}%")
                                                        ->orWhereHas('parent',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%");
                                                            })
                                                        ->orWhereHas('user',function($query) use($search){
                                                                $query->where('name','LIKE',"%{$search}%")
                                                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                                                    ->orWhere('phone_no', 'LIKE',"%{$search}%");
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
                                $nestedData['name']     =   $post->name;
                                $nestedData['parent']   =   $post->parent->name??'None';
                                $nestedData['owner']    =   $post->user->name;
                                $nestedData['email']    =   $post->user->email;
                                $nestedData['phone_no'] =   $post->user->phone_no;
                                $nestedData['status']   =   ($post->status == 1)?'Active':"inactive";
                                $nestedData['action']   =   '<div class="d-flex justify-content-between"></div><a href="'.route
                                    ('organization.edit',
                                        $post->id)
                                    .'"  class="text-dark mr-1" ><i class="fas fa-edit  "></i></a>
                                                                                    '.$actionbtn.'<a href="'.route('organization.product.index',$post->id).'"  class="text-dark ml-3" ><i class="fas fa-check-circle  "></i></a></div>';

                                $data[]                 =   $nestedData;

                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                return response()->json($json_data);
            }
    }
