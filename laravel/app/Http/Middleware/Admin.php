<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        if(empty(auth()->user())){
            return redirect()->route('login');
        }

        if(auth()->user()->role === 'admin'){
            $this->auth = true;
        } else {
            $this->auth = false;
        }

        if($this->auth === true){
            return $next($request);
        }
        
        return redirect()->route('login')->with('error', '権限がありません');
    }
}
