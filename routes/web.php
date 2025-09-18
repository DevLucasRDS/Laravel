<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\SendEmailContaController;

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
Route::get('/gerar-csv-conta', [ContaController::class, 'gerarCsv'])->name('contas.gerarCsv');
Route::get('/gerar-docx-conta', [ContaController::class, 'gerarDocx'])->name('contas.gerarDocx');
Route::get('/send-email-pendente-conta', [SendEmailContaController::class, 'sendEmailPendenteConta'])->name('contas.send-email-pendente-conta');
Route::get('/change-situation-conta/{conta}', [ContaController::class, 'ChangeSituation'])->name('contas.change-situation');
