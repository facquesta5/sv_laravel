<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HospitaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hospitais()
    {
        $hospitais = \DB::table('hospitais')->get();

        return view('hospitais')
                    ->with('hospitais', $hospitais);
        
        return view('hospitais');
    }

    public function incluir (Request $req) {

        \DB::beginTransaction();

        try {

            \DB::table('hospitais')->insert([
                "nome" => $req->nome
            ]);

            \DB::commit();

            return 'Hospital cadastrado com sucesso!';
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function alterar(Request $req) {
        \DB::beginTransaction();

        try {

            \DB::table('hospitais')->where('id', $req->id)->update([
                "nome" => $req->nome
            ]);

            \DB::commit();

            return 'Hospital cadastrado com sucesso!';

        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function excluir(Request $req) {
        
        \DB::beginTransaction();

        try {

            \DB::table('hospitais')->where('id', $req->id)->delete();

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            return csrf_token();
        }

    }



}
