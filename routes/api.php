<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\TecnicosController;

use App\Http\Controllers\EquiposController;
use App\Http\Controllers\PresidentesController;

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
//jugadores
Route::resource('jugador', JugadoresController::class); 
Route::post('edit-foto/{id}', [JugadoresController::class, 'editarfoto']);


//Equipos
Route::resource('equipos', EquiposController::class); 
Route::post('edit-foto-equipos/{id}', [EquiposController::class, 'editarfotoequipo']);

// Presidentes 
Route::resource('presidentes', PresidentesController::class); 

//Tecnico
Route::resource('tecnico', TecnicosController::class); 
Route::post('edit-foto-tecnico/{id}', [TecnicosController::class, 'editarfotoTecnico']);

Route::middleware('auth:sanctum')->group ( function () {


});
