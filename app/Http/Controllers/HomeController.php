<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function homeAdmin () {

        return view('home_admin')->with('sessao', \Session::all());

    }

    public function homeFuncionario () {

        return view('home_funcionario')->with('sessao', \Session::all());

    }
}
