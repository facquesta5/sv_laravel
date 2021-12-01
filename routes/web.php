<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipamentosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitaisController;
use App\Http\Controllers\OcorrenciasController;
use App\Http\Controllers\SistemasController;
use App\Http\Controllers\UsuariosController;
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

Route::get('/', [AuthController::class, 'login']);

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/auth', [AuthController::class, 'auth'])->name('auth'); // Autorização de login de usuário


Route::middleware('check.login')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); // localhost:8000/logout

    // Rotas Admin
    Route::middleware('check.admin')->group(function () {

        Route::get('/home/admin', [HomeController::class, 'homeAdmin'])->name('home.admin');

        Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('usuarios');
        Route::get('/usuarios/cadastro', [UsuariosController::class, 'cadastro_de_usuario'])->name('cadastro_de_usuario');
        Route::post('/usuarios/incluir', [UsuariosController::class, 'incluir']);
        Route::delete('/usuarios/excluir', [UsuariosController::class, 'excluir'])->name('usuarios.apagar');
        Route::put('/usuarios/alterar', [UsuariosController::class, 'alterar'])->name('usuarios.alterar');

        Route::get('/hospitais', [HospitaisController::class, 'hospitais'])->name('hospitais');
        //Route::post('/hospitais/incluir', 'App\Http\Controllers\HospitaisController@incluir')->name('cadastro');
        Route::post('/hospitais/incluir', [HospitaisController::class, 'incluir'])->name('cadastro');
        Route::delete('/hospitais/excluir', [HospitaisController::class, 'excluir'])->name('hospitais.apagar');
        Route::put('/hospitais/alterar', [HospitaisController::class, 'alterar'])->name('hospitais.alterar');

        Route::get('/sistemas', [SistemasController::class, 'sistemas'])->name('sistemas');
        Route::post('/sistemas/incluir', [SistemasController::class, 'incluir'])->name('cadastro');
        Route::delete('/sistemas/excluir', [SistemasController::class, 'excluir'])->name('sistemas.apagar');
        Route::put('/sistemas/alterar', [SistemasController::class, 'alterar'] )->name('sistemas.alterar');

        Route::get('/equipamentos', [EquipamentosController::class, 'equipamentos'])->name('equipamentos');
        Route::post('/equipamentos/incluir', [EquipamentosController::class, 'incluir'])->name('cadastro');
        Route::delete('/equipamentos/excluir', [EquipamentosController::class, 'excluir'])->name('equipamentos.apagar');
        Route::put('/equipamentos/alterar', [EquipamentosController::class, 'alterar'])->name('equipamentos.alterar');

        Route::get('/ocorrencias', [OcorrenciasController::class, 'ocorrencias'])->name('ocorrencias');
        Route::post('/ocorrencias/incluir', [OcorrenciasController::class,'incluir'] )->name('cadastro');
        Route::post('/ocorrencias/listEquipamentos', [OcorrenciasController::class, 'listEquipamentos'])->name('listarEquipamentos');
        Route::delete('/ocorrencias/excluir', [OcorrenciasController::class, 'excluir'] )->name('ocorrencias.apagar');
        Route::put('/ocorrencias/alterar', [OcorrenciasController::class, 'alterar'])->name('ocorrencias.alterar');
    });

    // Rotas Funcionario
    Route::middleware('check.funcionario')->group(function () {
        Route::get('/home/funcionario', 'App\Http\Controllers\HomeController@homeFuncionario')->name('home.funcionario');
    });
});
