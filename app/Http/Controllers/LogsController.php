<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class LogsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.logs.index',$this->data);
            }
        public function get(Request $request)
            {
                $columns = array(
                                    0   =>  'id',
                                    1   =>  'description',
                                    2   =>  'causer_id',
                                    3   =>  'subject_type',
                                    4   =>  'subject_id',
                                    5   =>  'properties',
                                    6   =>  'created_at'

                                );

                $totalData      =   Activity::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Activity::offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                    }
                else
                    {
                        $search =   $request->input('search.value');

                        $posts  =   Activity::whereHas("user",function ($subquery) use($search){
                                                        $subquery->where('name','LIKE',"%{$search}%");
                                                    })
                                                ->orWhere('description','LIKE',"%{$search}%")
                                                ->orWhere('subject_type','LIKE',"%{$search}%")
                                                ->orWhere('subject_id','LIKE',"%{$search}%")
                                                ->orWhere('properties','LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                        $totalFiltered =    Activity::whereHas("user",function ($subquery) use($search){
                                                            $subquery->where('name','LIKE',"%{$search}%");
                                                        })
                                                    ->orWhere('description','LIKE',"%{$search}%")
                                                    ->orWhere('subject_type','LIKE',"%{$search}%")
                                                    ->orWhere('subject_id','LIKE',"%{$search}%")
                                                    ->orWhere('properties','LIKE',"%{$search}%")
                                                    ->count();
                    }
                $data = array();
                if(!empty($posts))
                    {
                        $pos    =   $start+1;
                        foreach ($posts as $post)
                            {

                                $nestedData['pos']          =   $pos;
                                $nestedData['action']       =   $post->description;
                                $nestedData['executer']     =   $post->user->name??'System';
                                $nestedData['model']        =   $post->subject_type;
                                $nestedData['affectedid']   =   $post->subject_id;
                                $nestedData['change']       =   $post->properties;
                                $nestedData['time']         =   $post->created_at->format('h:ia d-m-Y');

                                $data[]                     =   $nestedData;
                                $pos++;
                            }
                    }

                $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
                echo json_encode($json_data);
            }
        public function export_view()
            {
                return view('modules.logs.index',$this->data);
            }
        public function export(Request $request)
            {

            }
    }
