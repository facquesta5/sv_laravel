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

Route::get('/', 'App\Http\Controllers\HomeController@home')->name('home');

Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');

Route::post('/auth', 'App\Http\Controllers\AuthController@auth');

Route::get('/usuarios', 'App\Http\Controllers\UsuariosController@usuarios')->name('usuarios');

// Rotas Admin
Route::middleware('check.admin')->group(function(){
    Route::get('/home/admin', 'App\Http\Controllers\HomeController@homeAdmin')->name('home.admin');    
});



// Rotas Cliente
Route::middleware('check.cliente')->group(function(){
    Route::get('/home/cliente', 'App\Http\Controllers\HomeController@homeCliente')->name('home.cliente');
});

Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::get('/usuarios/cadastro', 'App\Http\Controllers\UsuariosController@cadastro_de_usuario')->name('cadastro_de_usuario');
Route::post('/usuarios/incluir', 'App\Http\Controllers\UsuariosController@incluir');
Route::delete('/usuarios/excluir', 'App\Http\Controllers\UsuariosController@excluir')->name('usuarios.apagar');
Route::put('/usuarios/alterar', 'App\Http\Controllers\UsuariosController@alterar')->name('usuarios.alterar');


