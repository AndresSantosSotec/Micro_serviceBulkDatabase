<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

// Ruta para el dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Ruta para subir archivos
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');

// Ruta para guardar configuración del bucket AWS
Route::post('/config/aws', [UploadController::class, 'saveAwsConfig'])->name('config.aws');

// Ruta para guardar configuración local
Route::post('/config/local', [UploadController::class, 'saveLocalConfig'])->name('config.local');
