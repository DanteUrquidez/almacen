<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ParteController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\MovimientoController;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\AlmacenController;
use App\Http\Controllers\Admin\CajaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/habilitar', [App\Http\Controllers\Admin\UserController::class, 'habilitar'])->name('users.habilitar');

    Route::resource('partes', ParteController::class)->parameters(['partes' => 'parte']);
    Route::get('partes/{id}/movimientos', [ParteController::class, 'movimientos'])->name('partes.movimientos');
    Route::post('partes/{id}/registrar-movimiento', [ParteController::class, 'registrarMovimiento'])->name('partes.registrar-movimiento');
    Route::post('partes/{id}/entrada-rapida', [ParteController::class, 'entradaRapida'])->name('partes.entrada-rapida');
    Route::post('partes/{id}/salida-rapida', [ParteController::class, 'salidaRapida'])->name('partes.salida-rapida');

    Route::resource('categorias', CategoriaController::class)->parameters(['categorias' => 'categoria']);
    Route::get('/categorias/{id}/existencia', [CategoriaController::class, 'showExistencia'])->name('categorias.existencia');

    Route::resource('movimientos', MovimientoController::class);
    Route::post('movimientos/multiple', [MovimientoController::class, 'storeMultiple'])->name('movimientos.storeMultiple');
    Route::post('movimientos/multiple-packing', [MovimientoController::class, 'storeMultiplePacking'])->name('movimientos.storeMultiplePacking');

    Route::get('inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('inventario/sync', [InventarioController::class, 'syncInventario'])->name('inventario.sync');

    Route::post('partes/multiple', [ParteController::class, 'storeMultiple'])->name('partes.storeMultiple');
    Route::post('categorias/multiple', [CategoriaController::class, 'storeMultiple'])->name('categorias.storeMultiple');

    Route::resource('clientes', ClienteController::class)->parameters(['clientes' => 'cliente']);
    Route::post('clientes/multiple', [ClienteController::class, 'storeMultiple'])->name('clientes.storeMultiple');

    Route::resource('almacenes', AlmacenController::class)->parameters(['almacenes' => 'almacen']);
    Route::post('almacenes/multiple', [AlmacenController::class, 'storeMultiple'])->name('almacenes.storeMultiple');

    // Cajas (Packing List)
    Route::resource('cajas', CajaController::class)->parameters(['cajas' => 'caja']);
    Route::get('admin/cajas', [CajaController::class, 'index'])->name('cajas.index');
    Route::get('cajas/{caja}/pdf', [CajaController::class, 'generatePdf'])->name('cajas.pdf');


});
