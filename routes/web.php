<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

/**
 *  GET
 */
Route::get('/', function () {
    return view('welcome');
});

Route::get('registros', [RegisterController::class, 'listRegister'])->name('registers.index');
Route::get('registro/novo', [RegisterController::class, 'newRegister'])->name('registers.new');
Route::post('registro', [RegisterController::class, 'store'])->name('registers.store');
Route::get('registro/{id}/editar', [RegisterController::class, 'edit'])->name('registers.edit');

/**
 * PUT
 */
Route::put('registro/{id}', [RegisterController::class, 'update'])->name('registers.update');

/**
 * DELETE
 */
Route::delete('/registro/{id}', [RegisterController::class, 'destroy'])->name('registers.destroy');
