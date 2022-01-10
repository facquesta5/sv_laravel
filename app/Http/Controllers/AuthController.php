<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function auth(Request $req)
    {
        $credenciais = $req->validate([
            'nickname' => [
                'required',
                'string'
            ],
            'password' => [
                'required',
                'string'
            ]
        ]);

        if (!Auth::attempt($credenciais)) { // com ajax* Se a collection $credenciais estiver vazia, retorna ...
            return redirect()->back(); //força usuario a voltar para o lugar de onde veio
            //response()->json(false, 401);
        }

        $route = Auth::user()->nivel_id == '1' ? route('home.admin') : route('home.funcionario');

        return redirect($route);
    }

    public function logout()
    {
        Auth::logout();//Função para cuidar de remover a sessão de login do usuario

        return redirect()->route('login');
    }
}
