<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function homeAdmin () {

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
        
        return view('home_admin', ['ocorrencias' => $ocorrencias])->with('sessao', \Session::all());
    }

    public function homeFuncionario () {

        return view('home_funcionario')->with('sessao', \Session::all());

    }
}
