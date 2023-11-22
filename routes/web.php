<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
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

    Route::get('/dashboard/{id?}', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('appointments', AppointmentController::class);
    Route::get('/appointments/create/{mobile}', [AppointmentController::class, 'create'])->name('appointments.create.mobile');
    Route::resource('patients', PatientController::class);
    Route::get('/patients/create/{mobile}', [PatientController::class, 'create'])->name('patients.create.mobile');
    Route::get('/patient/history/{id}', [PatientController::class, 'history'])->name('patient.history');
    Route::get('/patient/search', [PatientController::class, 'search'])->name('patient.search');
    Route::get('/patient/searchbyphone', [PatientController::class, 'searchbyphone'])->name('patient.searchbyphone');
    Route::resource('users', UserController::class);
    Route::post('/appointments/addactivitylog', [AppointmentController::class,'addActivityLog'])->name('appointments.addactivitylog');

});


