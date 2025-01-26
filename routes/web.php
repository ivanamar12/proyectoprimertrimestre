<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\PruebasController;

Route::middleware('guest')->group(function () {
  Route::get('/', function () {
    return view('welcome');
  })->name('index');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/**
 * Auth Routes 
 */
require __DIR__ . '/auth.php';

/**
 * Specialist Routes 
 */
require __DIR__ . '/specialist.php';

/**
 * Secretary Routes 
 */
require __DIR__ . '/secretary.php';

// Ruta para la lista de representantes
Route::get('representantes', [RepresentativeController::class, 'index'])
  ->name('representantes.index')
  ->middleware('auth');

// Ruta para almacenar un nuevo representantes
Route::post('representantes', [RepresentativeController::class, 'store'])
  ->name('representantes.store')
  ->middleware('auth');

// Ruta para eliminar un representante
Route::delete('representantes/{id}', [RepresentativeController::class, 'destroy'])
  ->name('representantes.destroy')
  ->middleware('auth');

// Ruta para mostrar el formulario de edición de un representante
Route::get('representantes/{id}/edit', [RepresentativeController::class, 'edit'])
  ->name('representantes.edit')
  ->middleware('auth');

// Ruta para actualizar un representante
Route::put('representantes/{id}', [RepresentativeController::class, 'update'])
  ->name('representantes.update')
  ->middleware('auth');

// Ruta para obtener una secretaria específico en formato JSON
Route::get('representantes/{id}', [RepresentativeController::class, 'show'])
  ->name('representantes.show')
  ->middleware('auth');

// Ruta para la lista de paciente
Route::get('paciente', [PacienteController::class, 'index'])
  ->name('paciente.index')
  ->middleware('auth');


// Ruta para almacenar un nuevo paciente
Route::post('paciente', [PacienteController::class, 'store'])
  ->name('paciente.store')
  ->middleware('auth');

// Ruta para eliminar un paciente
Route::delete('paciente/{id}', [PacienteController::class, 'destroy'])
  ->name('paciente.destroy')
  ->middleware('auth');

// Ruta para mostrar el formulario de edición de un paciente
Route::get('paciente/{id}/edit', [PacienteController::class, 'edit'])
  ->name('paciente.edit')
  ->middleware('auth');

// Ruta para pacientes y especialistas
Route::get('citas', [CitaController::class, 'index'])
  ->name('citas.index')
  ->middleware('auth');

// Ruta para mostrar las citas 
Route::get('citas/web', [CitaController::class, 'indexWeb'])
  ->name('citas.indexWeb')
  ->middleware('auth');

// Ruta para agendar nueva cita
Route::post('citas', [CitaController::class, 'store'])
  ->name('citas.store')
  ->middleware('auth');

Route::get('citas/{id}/edit', [CitaController::class, 'edit'])
  ->name('citas.edit')
  ->middleware('auth');

// Ruta para actualizar el status de la cita
Route::put('citas/{id}', [CitaController::class, 'update'])
  ->name('citas.update')
  ->middleware('auth');

// Ruta para descargar reporte de todas las citas
Route::get('pdf/citas', [CitaController::class, 'generarPdfTodasLasCitas'])
  ->name('pdf.citas')
  ->middleware('auth');

// Ruta para descargar reporte de todas las citas del dia
Route::get('pdf/citas_hoy', [CitaController::class, 'citasDeHoy'])
  ->name('pdf.citas_hoy')
  ->middleware('auth');

// Ruta para descargar reporte de una cita
Route::get('pdf/generarPdfCita/{id}', [CitaController::class, 'generarPdfCita'])
  ->name('pdf.generarPdfCita')
  ->middleware('auth');

// Ruta para la lista de historias
Route::get('historias', [HistoriaClinicaController::class, 'index'])
  ->name('historias.index')
  ->middleware('auth');

// Ruta para creae nueva historia
Route::post('historias', [HistoriaClinicaController::class, 'store'])
  ->name('historias.store')
  ->middleware('auth');

// Ruta para almacenar una nueva especialidad
Route::post('especialidad', [EspecialidadController::class, 'store'])
  ->name('especialidad.store')
  ->middleware('auth');

// Ruta para eliminar una historia
Route::delete('historias/{id}', [HistoriaClinicaController::class, 'destroy'])
  ->name('historias.destroy')
  ->middleware('auth');

// Ruta para descargar reporte de una historia clínica
Route::get('pdf/generarPdfHistoria/{id}', [HistoriaClinicaController::class, 'generarPdfHistoria'])
  ->name('pdf.generarPdfHistoria')
  ->middleware('auth');

// Ruta para la lista de pruebas
Route::get('pruebas', [PruebasController::class, 'index'])
  ->name('pruebas.index')
  ->middleware('auth');

// Grupo de rutas que utiliza el middleware 'web'
Route::middleware(['web', 'auth'])->group(function () {
  // Ruta para almacenar una nueva área de desarrollo
  Route::post('pruebas/area-desarrollo', [PruebasController::class, 'storeAreaDesarrollo'])
    ->name('pruebas.storeAreaDesarrollo');

  // Ruta para almacenar un nuevo tipo de prueba
  Route::post('pruebas/tipo-prueba', [PruebasController::class, 'storeTipoPrueba'])
    ->name('pruebas.storeTipoPrueba');

  // Ruta para almacenar un nuevo rango de prueba
  Route::post('pruebas/rango-prueba', [PruebasController::class, 'storeRangoPrueba'])
    ->name('pruebas.storeRangoPrueba');

  // Ruta para almacenar un nueva prueba
  Route::post('pruebas/prueba', [PruebasController::class, 'storePrueba'])
    ->name('pruebas.storePrueba');

  Route::post('pruebas/cambiar-estatus', [PruebasController::class, 'cambiarEstatus'])
    ->name('pruebas.cambiarEstatus');
});

Route::get('pruebas/{id}', [PruebasController::class, 'show'])
  ->name('pruebas.show')
  ->middleware('auth');
