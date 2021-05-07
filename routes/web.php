<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/schedule', [AppointmentController::class, 'schedule'])->name('appointment.schedule');

Route::get('/history', [AppointmentController::class, 'history'])->name('appointment.history');

Route::get('/appointment/{id}/{title}', [AppointmentController::class, 'show'])->name('appointment.show');

Route::get('/appointment/{id}/{title}/edit', [AppointmentController::class, 'edit'])->name('appointment.edit');

Route::post('/appointment/{id}/update', [AppointmentController::class, 'update'])->name('appointment.update');