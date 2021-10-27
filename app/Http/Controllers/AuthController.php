<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }
    
    public function auth (Request $req) {

        \Session::flush();

        $usuario = $req->usuario;
        $senha = sha1($req->senha);

        $dadosUsuario = \DB::table('usuarios')->where('usuario', $usuario)->where('access_token', $senha)->get(); // SELECT * FROM usuarios WHERE usuario = usuario AND access_token = senha

        if (empty($dadosUsuario[0])) { // Se a collection $dadosUsuario estiver vazia, retorna 0

            return 0;

        } else { // Se não, retorna 1
                   
            $session_params = [
                'id' => $dadosUsuario[0]->id,
                'nivel_id' => $dadosUsuario[0]->nivel_id,
                'usuario' => $dadosUsuario[0]->usuario
            ];
            
            \Session::put($session_params);
            \Session::save();

            if ($session_params['nivel_id'] == 1) { // Se for admin
                return response()->json([
                    'status' => 'home/admin',
                    'token' => csrf_token()
                ]);
        } else if ($session_params['nivel_id'] == 2) { // Se for funcionario
                return response()->json([
                    'status' => 'home/funcionario',
                    'token' => csrf_token()
                ]);
            }
        }
    }

    public function logout(){

        \Session::flush();

        return redirect(route('login'));

    }
}
