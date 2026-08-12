<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\CobroController;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('clientes.index');
});


/*
|--------------------------------------------------------------------------
| Módulo de Clientes
|--------------------------------------------------------------------------
*/

Route::resource('clientes', ClienteController::class);


/*
|--------------------------------------------------------------------------
| Módulo de Préstamos
|--------------------------------------------------------------------------
*/

// Lista de todos los préstamos
Route::get(
    '/prestamos',
    [PrestamoController::class, 'index']
)->name('prestamos.index');


// Formulario para crear préstamo de un cliente
Route::get(
    '/clientes/{cliente}/prestamos/create',
    [PrestamoController::class, 'create']
)->name('prestamos.create');


// Guardar préstamo
Route::post(
    '/clientes/{cliente}/prestamos',
    [PrestamoController::class, 'store']
)->name('prestamos.store');


// Ver préstamo
Route::get(
    '/prestamos/{prestamo}',
    [PrestamoController::class, 'show']
)->name('prestamos.show');


// Formulario editar préstamo
Route::get(
    '/prestamos/{prestamo}/edit',
    [PrestamoController::class, 'edit']
)->name('prestamos.edit');


// Actualizar préstamo
Route::put(
    '/prestamos/{prestamo}',
    [PrestamoController::class, 'update']
)->name('prestamos.update');


// Cancelar préstamo
Route::delete(
    '/prestamos/{prestamo}',
    [PrestamoController::class, 'destroy']
)->name('prestamos.destroy');

// cobro 
Route::get(
    '/cuotas/{cuota}/pagar',
    [CobroController::class, 'create']
)->name('cobros.create');

Route::post(
    '/cuotas/{cuota}/pagar',
    [CobroController::class, 'store']
)->name('cobros.store');