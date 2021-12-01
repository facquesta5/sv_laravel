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

        dd(Auth::user());
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

        if (!Auth::attempt($credenciais)) { // Se a collection $dadosUsuario estiver vazia, retorna 0

            return response()->json(false, 401);
        }

        $status = [
            1 => 'home/admin',
            2 => 'home/funcionario',
        ];
        return response()->json([
            // 'status' => $status[$dadosUsuario->nivel_id],
            // 'token' => csrf_token()
        ]);
    }

    public function logout()
    {

        Session::flush();

        return redirect(route('login'));
    }
}
