<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;

class Clients
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
            $cid        =  $request->user()->company_id;
            $categories =  Organization::where('id',$cid)
                                        ->orWhere('parent_company',$cid)
                                        ->get();
            $company_id = array_column($categories->toArray(),'id');
            $check      =   Organization::find($cid);
            $data       =   ['cid'=>$company_id];
            if($check->parent_company == 0)
                {
                    $data['orgtype']    =   'owner';
                }
            else
                {
                    $data['orgtype']    =   'client';
                }
            $request->request->add($data);
            return $next($request);

        }
}
