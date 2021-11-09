<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\AuthController@login'); 

Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');

Route::post('/auth', 'App\Http\Controllers\AuthController@auth'); // Autorização de login de usuário

Route::get('/usuarios', 'App\Http\Controllers\UsuariosController@usuarios')->name('usuarios');


Route::middleware('check.login')->group(function() {

    Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout'); // localhost:8000/logout

    // Rotas Admin
    Route::middleware('check.admin')->group(function(){

        Route::get('/home/admin', 'App\Http\Controllers\HomeController@homeAdmin')->name('home.admin');

        Route::get('/usuarios', 'App\Http\Controllers\UsuariosController@usuarios')->name('usuarios');
        Route::get('/usuarios/cadastro', 'App\Http\Controllers\UsuariosController@cadastro_de_usuario')->name('cadastro_de_usuario');
        Route::post('/usuarios/incluir', 'App\Http\Controllers\UsuariosController@incluir');
        Route::delete('/usuarios/excluir', 'App\Http\Controllers\UsuariosController@excluir')->name('usuarios.apagar');
        Route::put('/usuarios/alterar', 'App\Http\Controllers\UsuariosController@alterar')->name('usuarios.alterar');

        Route::get('/hospitais', 'App\Http\Controllers\HospitaisController@hospitais')->name('hospitais');
        Route::post('/hospitais/incluir', 'App\Http\Controllers\HospitaisController@incluir')->name('cadastro');
        Route::delete('/hospitais/excluir', 'App\Http\Controllers\HospitaisController@excluir')->name('hospitais.apagar');
        Route::put('/hospitais/alterar', 'App\Http\Controllers\HospitaisController@alterar')->name('hospitais.alterar');
        
        Route::get('/sistemas', 'App\Http\Controllers\SistemasController@sistemas')->name('sistemas');
        Route::post('/sistemas/incluir', 'App\Http\Controllers\SistemasController@incluir')->name('cadastro');
        Route::delete('/sistemas/excluir', 'App\Http\Controllers\SistemasController@excluir')->name('sistemas.apagar');
        Route::put('/sistemas/alterar', 'App\Http\Controllers\sistemasController@alterar')->name('sistemas.alterar');
   
        Route::get('/equipamentos', 'App\Http\Controllers\EquipamentosController@equipamentos')->name('equipamentos');
        Route::post('/equipamentos/incluir', 'App\Http\Controllers\EquipamentosController@incluir')->name('cadastro');
        Route::delete('/equipamentos/excluir', 'App\Http\Controllers\EquipamentosController@excluir')->name('equipamentos.apagar');
        Route::put('/equipamentos/alterar', 'App\Http\Controllers\EquipamentosController@alterar')->name('equipamentos.alterar');

        Route::get('/ocorrencias', 'App\Http\Controllers\OcorrenciasController@ocorrencias')->name('ocorrencias');
        Route::post('/ocorrencias/incluir', 'App\Http\Controllers\OcorrenciasController@incluir')->name('cadastro');
    });

    // Rotas Funcionario
    Route::middleware('check.funcionario')->group(function(){
        Route::get('/home/funcionario', 'App\Http\Controllers\HomeController@homeFuncionario')->name('home.funcionario');
    });

});



