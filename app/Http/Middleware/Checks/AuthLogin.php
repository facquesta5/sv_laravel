<?php

namespace App\Http\Middleware\Checks;

use Closure;
use Illuminate\Http\Request;

class AuthLogin
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
        if(\Session::get('id')){ // Se tiver variáveis de sessão
            return $next($request); // $next é o objeto da classe Closure
        }

        return redirect(route('login'));
    }
}
