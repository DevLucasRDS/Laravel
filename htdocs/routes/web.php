<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContaController;

Route::get('/', function () {
    return view('welcome');
});
//Contas
Route::get('/index-conta', [ContaController::class, 'index'])->name('contas.index');
Route::get('/create-conta', [ContaController::class, 'create'])->name('contas.create');
Route::post('/store-conta', [ContaController::class, 'store'])->name('contas.store');
Route::get('/show-conta/{conta}', [ContaController::class, 'show'])->name('contas.show');
Route::get('/edit-conta/{conta}', [ContaController::class, 'edit'])->name('contas.edit');
Route::put('/update-conta/{conta}', [ContaController::class, 'update'])->name('contas.update');
Route::delete('/destroy-conta/{conta}', [ContaController::class, 'destroy'])->name('contas.destroy');
Route::get('/gerar-pdf-conta', [ContaController::class, 'gerarPdf'])->name('contas.gerarPdf');
