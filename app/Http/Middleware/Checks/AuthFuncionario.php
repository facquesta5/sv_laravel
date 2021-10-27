<?php

namespace App\Http\Middleware\Checks;

use Closure;
use Illuminate\Http\Request;

class AuthFuncionario
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
        if(\Session::get('nivel_id') == 2){ // Se for cliente
            return $next($request); // $next é o objeto da classe Closure
        }
        
        return redirect(route('denied'));
    }
}
