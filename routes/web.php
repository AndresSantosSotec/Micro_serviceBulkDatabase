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
    return view('welcome');
});

// Ruta para el dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');