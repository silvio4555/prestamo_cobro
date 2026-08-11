<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\CobroController;
/* cobro*/
Route::get('/cuotas/{cuota}/pagar', [CobroController::class, 'create'])
    ->name('cobros.create');

Route::post('/cuotas/{cuota}/pagar', [CobroController::class, 'store'])
    ->name('cobros.store');
    
/* CLIENTE*/
Route::get('/', function () {
    return redirect()->route('clientes.index');
});

Route::resource('clientes', ClienteController::class);

/*prestamo*/ 


Route::resource('clientes', ClienteController::class);

Route::get('/clientes/{cliente}/prestamos/create', [PrestamoController::class, 'create'])
    ->name('prestamos.create');

Route::post('/clientes/{cliente}/prestamos', [PrestamoController::class, 'store'])
    ->name('prestamos.store');

Route::get('/prestamos/{prestamo}', [PrestamoController::class, 'show'])
    ->name('prestamos.show');