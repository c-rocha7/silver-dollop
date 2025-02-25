<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/empresas', [EmpresaController::class, 'store']);
Route::get('/empresas', [EmpresaController::class, 'index']);
Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'show']);
Route::put('/empresas/{empresa}', [EmpresaController::class, 'update']);
Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy']);

Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes', [ClienteController::class, 'index']);
Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'show']);
Route::put('/clientes/{cliente}', [ClienteController::class, 'update']);
Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy']);
