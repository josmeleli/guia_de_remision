<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transportistaController;
use App\Http\Controllers\vehiculoController;
use App\Http\Controllers\agricultorController;
use App\Http\Controllers\choferController;
use App\Http\Controllers\cargaController;
use App\Http\Controllers\campoController;
use App\Http\Controllers\FiltrosAvanzadosController;
use App\Http\Controllers\guiaController;
use App\Http\Controllers\PagoController;
use App\Models\pago;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('menu');
});

// Ruta protegida por un Middleware
Route::middleware('auth')->group(function () {
    // Ruta para mostrar el menú (GET)
    Route::get('/', [VehiculoController::class, 'mostrarMenu'])->name('mostrar.menu');

    // Ruta para almacenar un nuevo transportista (POST)
    Route::post('/transportista', [TransportistaController::class, 'store'])->name('transportistas.store');

    // Ruta para almacenar un nuevo vehículo (POST)
    Route::post('/vehiculo', [VehiculoController::class, 'store'])->name('vehiculo.store');

    Route::get('agricultor/create', [AgricultorController::class, 'create'])->name('agricultor.create');
    Route::post('agricultor/store', [AgricultorController::class, 'store'])->name('agricultor.store');

    Route::post('conductor/store', [choferController::class, 'store'])->name('conductor.store');
    Route::post('carga/store', [cargaController::class, 'store'])->name('carga.store');

    Route::post('campo/store', [CampoController::class, 'store'])->name('campo.store');

    Route::post('/crear-pago', [PagoController::class, 'store'])->name('pagos.store');

    Route::post('/guia_remision/store', [guiaController::class, 'store'])->name('guia_remision.store');

    Route::get('/guia-remision', [GuiaController::class, 'index'])->name('guia-remision.index');

   
    Route::get('/guias/{guia}', [GuiaController::class, 'show'])->name('guias.show');

    // Rutas para crear una nueva guía de remisión
    Route::get('/guias/create', [GuiaController::class, 'create'])->name('guias.create');
    Route::post('/guias', [GuiaController::class, 'store'])->name('guias.store');

    // Rutas para editar una guía de remisión existente
    Route::get('/guias/{guia}/edit', [GuiaController::class, 'edit'])->name('guias.edit');
    Route::put('/guias/{guia}', [GuiaController::class, 'update'])->name('guias.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/guias/{guia}', [GuiaController::class, 'destroy'])->name('guias.destroy');

    Route::delete('borrar-guias-seleccionadas', [GuiaController::class, 'borrarSeleccionados'])->name('guia_remision.borrar_seleccionados');
    Route::get('/pagos', [pagoController::class, 'index'])->name('pago.index');
    Route::get('/pagos/{pago}/edit', [PagoController::class, 'edit'])->name('pago.edit');
    Route::put('/pagos/{pago}', [pagoController::class, 'update'])->name('pago.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/pagos/{pago}', [pagoController::class, 'destroy'])->name('pago.destroy');
    Route::delete('borrar-pagos-seleccionados', [PagoController::class, 'borrarSeleccionados'])->name('pago.borrar_seleccionados');

    Route::get('/campos', [campoController::class, 'index'])->name('campo.index');
    Route::get('/campos/{campo}/edit', [campoController::class, 'edit'])->name('campo.edit');
    Route::put('/campos/{campo}', [campoController::class, 'update'])->name('campo.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/campos/{campo}', [campoController::class, 'destroy'])->name('campo.destroy');

    Route::get('/conductores', [choferController::class, 'index'])->name('conductor.index');
    Route::get('/conductores/{conductor}/edit', [choferController::class, 'edit'])->name('conductor.edit');
    Route::put('/conductores/{conductor}', [choferController::class, 'update'])->name('conductor.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/conductores/{conductor}', [choferController::class, 'destroy'])->name('conductor.destroy');

    Route::get('/transportistas', [transportistaController::class, 'index'])->name('transportista.index');
    Route::get('/transportistas/{transportista}/edit', [transportistaController::class, 'edit'])->name('transportista.edit');
    Route::put('/transportistas/{transportista}', [transportistaController::class, 'update'])->name('transportista.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/transportistas/{transportista}', [transportistaController::class, 'destroy'])->name('transportista.destroy');

    Route::get('/agricultores', [agricultorController::class, 'index'])->name('agricultor.index');
    Route::get('/agricultores/{agricultor}/edit', [agricultorController::class, 'edit'])->name('agricultor.edit');
    Route::put('/agricultores/{agricultor}', [agricultorController::class, 'update'])->name('agricultor.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/agricultores/{agricultor}', [agricultorController::class, 'destroy'])->name('agricultor.destroy');

    
    Route::get('/vehiculos', [vehiculoController::class, 'index'])->name('vehiculo.index');
    Route::get('/vehiculos/{vehiculo}/edit', [vehiculoController::class, 'edit'])->name('vehiculo.edit');
    Route::put('/vehiculos/{vehiculo}', [vehiculoController::class, 'update'])->name('vehiculo.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/vehiculos/{vehiculo}', [vehiculoController::class, 'destroy'])->name('vehiculo.destroy');

    Route::get('/cargas', [cargaController::class, 'index'])->name('carga.index');
    Route::get('/cargas/{carga}/edit', [cargaController::class, 'edit'])->name('carga.edit');
    Route::put('/cargas/{carga}', [cargaController::class, 'update'])->name('carga.update');

    // Rutas para eliminar una guía de remisión existente
    Route::delete('/cargas/{carga}', [cargaController::class, 'destroy'])->name('carga.destroy');

    Route::get('/filtros-avanzados', [FiltrosAvanzadosController::class, 'mostrarFiltrosAvanzados'])->name('filtros.avanzados');

    Route::get('/filtro-avanzado', [FiltrosAvanzadosController::class, 'filtrar'])->name('filtro.avanzado');

    Route::get('/verificar-ruc', [GuiaController::class, 'verificarRuc']);

    Route::post('/buscar-transportista', [TransportistaController::class, 'buscarPorRUC'])->name('transportista.buscarPorRUC');

    Route::get('/crear-guia-remision', [guiaController::class, 'create'])->name('crear_guia_remision');


    


    

});








