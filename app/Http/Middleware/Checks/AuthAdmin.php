<?php

namespace App\Http\Middleware\Checks;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->nivel_id == 1){ // Se for admin
            return $next($request); // $next é o objeto da classe Closure
        }

        return redirect(route('login'));

    }
}
