<?php

namespace App\Http\Controllers;

use App\Models\Failed_job;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
    {
        public function failed()
            {
                return view('modules.jobs.failed',$this->data);
            }
        public function get_failed(Request $request)
            {
                $columns        =   array( 0 => 'id' , 1 => 'connection' , 2 => 'queue' , 3 => 'payload' , 4 => 'exception',5=>'failed_at' );
                $totalData      =   Failed_job::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts =    Failed_job::offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   Failed_job::where('connection','LIKE',"%{$search}%")
                                                    ->orWhere('queue', 'LIKE',"%{$search}%")
                                                    ->orWhere('payload', 'LIKE',"%{$search}%")
                                                    ->orWhere('exception', 'LIKE',"%{$search}%")
                                                    ->offset($start)
                                                    ->limit($limit)
                                                    ->orderBy($order,$dir)
                                                    ->get();

                        $totalFiltered  =  Failed_job::where('connection','LIKE',"%{$search}%")
                                                    ->orWhere('queue', 'LIKE',"%{$search}%")
                                                    ->orWhere('payload', 'LIKE',"%{$search}%")
                                                    ->orWhere('exception', 'LIKE',"%{$search}%")
                                                    ->count();
                    }

                $data = array();
                if(!empty($posts))
                {
                    foreach ($posts as $post)
                    {

                        $nestedData['id']               =   $post->id;
                        $nestedData['connection']       =   $post->connection;
                        $nestedData['queue']            =   $post->queue;
                        $nestedData['payload']          =   $post->payload;
                        $nestedData['exception']        =   $post->exception;
                        $nestedData['failed_at']        =   $post->failed_at;
                        $data[]                         =   $nestedData;

                    }
                }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                echo json_encode($json_data);
            }
        public function queued()
            {
                return view('modules.jobs.queued',$this->data);
            }
        public function get_queued(Request $request)
            {
                $columns        =   array( 0 => 'id' , 1 => 'attempts' , 2 => 'queue' , 3 => 'payload' , 4 => 'role',5=>'reserved_at',6=>'available_at',7=>'created_at' );
                $totalData      =   Job::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = Job::offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   Job::where('attempts','LIKE',"%{$search}%")
                                                ->orWhere('queue', 'LIKE',"%{$search}%")
                                                ->orWhere('payload', 'LIKE',"%{$search}%")
                                                ->orWhere('role', 'LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                        $totalFiltered  =   Job::where('attempts','LIKE',"%{$search}%")
                                                ->orWhere('queue', 'LIKE',"%{$search}%")
                                                ->orWhere('payload', 'LIKE',"%{$search}%")
                                                ->orWhere('role', 'LIKE',"%{$search}%")
                                                ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        foreach ($posts as $post)
                            {

                                $nestedData['id']               =   $post->id;
                                $nestedData['attempts']         =   $post->attempts;
                                $nestedData['queue']            =   $post->queue;
                                $nestedData['payload']          =   $post->payload;
                                $nestedData['reserved_at']      =   $post->reserved_at;
                                $nestedData['available_at']     =   $post->available_at;
                                $nestedData['created_at']       =   $post->created_at;
                                $data[]                         =   $nestedData;

                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                echo json_encode($json_data);
            }
    }
