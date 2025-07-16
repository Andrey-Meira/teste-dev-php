<?php

use App\Http\Controllers\FornecedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/', [FornecedorController::class, 'index']);
Route::get('/fornecedores', [FornecedorController::class, 'index']);
Route::post('/fornecedor', [FornecedorController::class, 'store']);
Route::get('/fornecedor/{id}', [FornecedorController::class, 'show']);
Route::put('/fornecedor/{id}', [FornecedorController::class, 'update']);
Route::delete('/fornecedor/{id}', [FornecedorController::class, 'destroy']);
Route::get('/busca-cnpj/{cnpj}', [FornecedorController::class, 'buscarPorCNPJ']);
