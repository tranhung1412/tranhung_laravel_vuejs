<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckAdmin
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
        if(Auth::check()){
            if(count(Auth::user()->role)!==0){
                return $next($request);
            }else {
                return redirect()->route('login.admin')->with('error','ban khong co quyen vao trang nay');
            }
        }else{
             return redirect()->route('login.admin')->with('error','ban chua dang nhap');
        }
    }
}
