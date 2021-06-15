<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class authKey
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
        $token = $request->header('APIKEY');
        if($token != 'helloatg'){
            return response(["status"=>"1","Message"=>"Invalid API Key"],401);
        }
        return $next($request);
    }
}
