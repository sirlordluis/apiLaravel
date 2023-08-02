<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/administrador', 'App\Http\Controllers\AdministradorController@index');
Route::post('/administrador', 'App\Http\Controllers\AdministradorController@store');
Route::get('/administrador/{administrador}', 'App\Http\Controllers\AdministradorController@show');
Route::put('/administrador/{administrador}', 'App\Http\Controllers\AdministradorController@update');
Route::delete('/administrador/{administrador}', 'App\Http\Controllers\AdministradorController@destroy');

Route::get('/denuncia', 'App\Http\Controllers\DenunciaController@index');
Route::post('/denuncia', 'App\Http\Controllers\DenunciaController@store');
Route::get('/denuncia/{idOrFolio}', 'App\Http\Controllers\DenunciaController@showByFolioOrId');
Route::put('/denuncia/{denuncia}', 'App\Http\Controllers\DenunciaController@update');
Route::delete('/denuncia/{denuncia}', 'App\Http\Controllers\DenunciaController@destroy');
/*BUSCAR DENUNCIAS DE ESE ADMINISTRADOR*/
Route::get('/administrador/denuncia/{id}', 'App\Http\Controllers\AdministradorController@attach');
/*BUSCAR DATOS DE ESE ADMINISTRADOR*/
Route::get('/administrador/auth/{email}', 'App\Http\Controllers\AdministradorController@busqueda');




