<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('patients', PatientController::class);
    Route::get('/patient/history/{id}', [PatientController::class, 'history'])->name('patient.history');
    Route::get('/patient/search', [PatientController::class, 'search'])->name('patient.search');
    Route::get('/patient/searchbyphone', [PatientController::class, 'searchbyphone'])->name('patient.searchbyphone');
    Route::resource('users', UserController::class);
});
