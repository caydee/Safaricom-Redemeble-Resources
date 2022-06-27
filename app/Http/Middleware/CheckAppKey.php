<?php

namespace App\Http\Middleware;


use Closure;

class CheckAppKey
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
            {
                $appkey = $request->header('appkey');
                if(is_null($appkey))
                    {
                        return response()->json(['status' => false,'error' => "Unauthorized action"], 401);
                    }
                else
                    {
                        $key = '3UhZEQ9pSQ6GxGh4hZbwvzWRvLqX6CrrNjH49MkLxxXSF';
                        if($key !== $appkey)
                            return response()->json(['status' => false,'error' => "Invalid token"], 401);
                    }

                return $next($request);
            }
    }
