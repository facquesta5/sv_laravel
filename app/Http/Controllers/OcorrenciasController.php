<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OcorrenciasController extends Controller
{
    public function ocorrencias(){

        $ocorrencias = \DB::table('ocorrencias')
            ->join('hospitais', 'hospitais.id', '=', 'ocorrencias.id_hospital')
            ->join('sistemas', 'sistemas.id', '=', 'ocorrencias.id_sistema')
            ->join('equipamentos', 'equipamentos.id', '=', 'ocorrencias.id_equipamento')
            ->select(
                'ocorrencias.id',
                'ocorrencias.id_status',
                'ocorrencias.descricao',
                'equipamentos.id as id_equipamento',
                'equipamentos.nome as equipamento',
                'hospitais.nome as hospital',
                'hospitais.id as id_hospital',
                'sistemas.nome as sistema', 
                'sistemas.id as id_sistema',
            )
            ->orderBy('id', 'DESC')
        ->get();

        $sistemas = \DB::table('sistemas')->get();
        $hospitais = \DB::table('hospitais')->get();
        $equipamentos = \DB::table('equipamentos')->get();

        return view('ocorrencias', [ 
            'equipamentos' => $equipamentos,
            'ocorrencias' => $ocorrencias,
            'sistemas' => $sistemas, 
            'hospitais' => $hospitais,
        ]);

        return view('ocorrencias');
    }

    public function incluir (Request $req) {

        \DB::beginTransaction();

        try {

            \DB::table('ocorrencias')->insert([
                "id_equipamento" => $req->id_equipamento,
                "id_sistema" => $req->id_sistema,
                "id_hospital" => $req->id_hospital,
                "id_status" => $req->id_status,
                "descricao" => $req->descricao
            ]);

            \DB::commit();

            return 'Ocorrencia cadastrado com sucesso!';
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function listEquipamentos(Request $req){
        
        $equipamentos = \DB::table('equipamentos')
        ->select(
            'equipamentos.id',
            'equipamentos.nome',
        )
        ->where('equipamentos.id_sistema', $req->id_sistema)
        ->where('equipamentos.id_hospital', $req->id_hospital)
        ->orderBy('id', 'DESC')
        ->get();

        return $equipamentos;

    }

    public function alterar(Request $req) {
        \DB::beginTransaction();

        try {

            \DB::table('ocorrencias')
            ->where('id', $req->id)->update([
                "id_equipamento" => $req->id_equipamento,
                "id_sistema" => $req->id_sistema,
                "id_hospital" => $req->id_hospital,
                "id_status" => $req->id_status,
                "descricao" => $req->descricao
            ]);

            \DB::commit();

            return 'Ocorrencia alterada com sucesso!';

        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function excluir(Request $req) {
        
        \DB::beginTransaction();

        try {

            \DB::table('ocorrencias')->where('id', $req->id)->delete();

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            return csrf_token();
        }

    }
}
