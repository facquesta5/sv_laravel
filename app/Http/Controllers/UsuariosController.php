<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function usuarios(){
        
        $usuarios = \DB::table('usuarios')->get();

        return view('usuarios')
                    ->with('usuarios', $usuarios);
        
        return view('usuarios');

    }
    public function dados_de_usuario(){
        return view('usuario.dados');
    }

    public function incluir (Request $req) {

        \DB::beginTransaction();

        try {

            \DB::table('usuarios')->insert([
                "nivel_id" => 1, // 1 = Admin, 2 = Cliente // Sempre será cliente
                "nome" => $req->nome,
                "usuario" => $req->usuario,
                "email" => $req->email,
                "access_token" => sha1($req->senha),
            ]);

            \DB::commit();

            return 'Cliente cadastrado com sucesso!';
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function alterar(Request $req) {
        \DB::beginTransaction();

        try {

            \DB::table('usuarios')->where('id', $req->id)->update([

                "nome" => $req->nome,
                "email" => $req->email,
                "usuario" => $req->usuario
            ]);

            \DB::commit();

            return 'Usuário cadastrado com sucesso!';

        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function excluir(Request $req) {
        
        \DB::beginTransaction();

        try {

            \DB::table('usuarios')->where('id', $req->id)->delete();

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            return csrf_token();
        }

    }
}
