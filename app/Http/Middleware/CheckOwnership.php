<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOwnership
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next)
            {
                if(Auth::check())
                    {
                        $id     =   array(Auth::user()->organization_id);
                        $org    =   Organization::find($id[0]);
                        if($org->parent_id == 0)
                            $request->request->add(['owner'=>TRUE]);

                        if(!is_null($org->children))
                            {
                                $children   =   $org->children->pluck('id');
                                $data       =   $children->all();
                                array_push($data,$id);
                            }
                        $request->request->add(['org'=>$id]);
                    }


                return $next($request);
            }
    }
