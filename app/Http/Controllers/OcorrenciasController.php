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

        return view('ocorrencias', [ 
            'sistemas' => $sistemas, 
            'hospitais' => $hospitais
        ]);

        return view('ocorrencias');
    }
}
