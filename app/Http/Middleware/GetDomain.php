<?php

namespace App\Http\Middleware;

//use App\Models\Product;
use Closure;
use Illuminate\Http\Request;

class GetDomain
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
            $domain     =   strtolower(str_replace('www.','',$request->server->get('SERVER_NAME')));

            $request->request->add(['domain'=>$domain]);
            return $next($request);
        }
}
