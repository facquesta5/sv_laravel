<?php

namespace App\Http\Middleware\Checks;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
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
        if(\Session::get('nivel_id') == 1){ // Se for admin
            return $next($request); // $next é o objeto da classe Closure
        }else{
            return redirect(route('login'));
        }
        
        return redirect(route('home.admin'));
    }
}