<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipamentosController extends Controller
{
    
    public function Equipamentos(){
    
        $equipamentos = \DB::table('equipamentos')
            ->join('hospitais', 'hospitais.id', '=', 'equipamentos.id_hospital')
            ->join('sistemas', 'sistemas.id', '=', 'equipamentos.id_sistema')
            ->select(
                'equipamentos.nome',
                'equipamentos.id',
                'hospitais.nome as hospital',
                'hospitais.id as id_hospital',
                'sistemas.nome as sistema', 
                'sistemas.id as id_sistema',
            )
            ->orderBy('id', 'DESC')
        ->get();

        $sistemas = \DB::table('sistemas')->get();

        $hospitais = \DB::table('hospitais')->get();

        return view('equipamentos', [
            'equipamentos'=> $equipamentos, 
            'sistemas' => $sistemas, 
            'hospitais' => $hospitais
        ]);

        return view('equipamentos');

    }

    public function incluir (Request $req) {

        \DB::beginTransaction();

        try {

            \DB::table('equipamentos')->insert([
                "id_hospital" => $req->id_hospital,
                "id_sistema" => $req->id_sistema,
                "nome" => $req->nome
            ]);

            \DB::commit();

            return 'Equipamento cadastrado com sucesso!';
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function alterar(Request $req) {
        \DB::beginTransaction();

        try {

            \DB::table('equipamentos')->where('id', $req->id)->update([
                "id_hospital" => $req->id_hospital,
                "id_sistema" => $req->id_sistema,   
                "nome" => $req->nome
            ]);

            \DB::commit();

            return 'Equipamento alterado com sucesso!';

        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function excluir(Request $req) {
        
        \DB::beginTransaction();

        try {

            \DB::table('equipamentos')->where('id', $req->id)->delete();

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            return csrf_token();
        }

    }
}
