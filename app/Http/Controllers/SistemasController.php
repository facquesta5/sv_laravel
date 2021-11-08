<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SistemasController extends Controller
{
    public function sistemas(){
        
        $sistemas = \DB::table('sistemas')
            ->join('hospitais', 'hospitais.id', '=', 'sistemas.id_hospital')
            ->select(
                'sistemas.nome', 
                'hospitais.id', 
                'sistemas.id_hospital',
                'hospitais.nome as hospital',
                'sistemas.id as id_sistema')
        ->get();

        $hospitais = \DB::table('hospitais')->get();

        return view('sistemas',['sistemas' => $sistemas , 'hospitais' => $hospitais]);

    }

    public function incluir (Request $req) {

        \DB::beginTransaction();

        try {

            \DB::table('sistemas')->insert([
                "id_hospital" => $req->id_hospital,
                "nome" => $req->nome
            ]);

            \DB::commit();

            return 'Sistema cadastrado com sucesso!';
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function alterar(Request $req) {
        \DB::beginTransaction();

        try {

            \DB::table('sistemas')->where('id', $req->id)->update([
                "id_hospital" => $req->id_hospital,   
                "nome" => $req->nome
            ]);

            \DB::commit();

            return 'Sistema alterado com sucesso!';

        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }


    public function excluir(Request $req) {
        
        \DB::beginTransaction();

        try {

            \DB::table('sistemas')->where('id', $req->id)->delete();

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            return csrf_token();
        }

    }

}
