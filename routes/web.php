<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PatientVacinateController;
use App\Http\Controllers\VacineCalendarController;
use Illuminate\Support\Facades\Route;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('pages.dashboard');
// })->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/offline', function(){
    return view('offlines.offline');
});
Route::get('/list_vacinate', function(){
    return view('offlines.list_vacinate');
})->middleware('auth');

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
});

Route::resource('patient', PatientsController ::class)->middleware('auth');
Route::resource('vaccinate', PatientVacinateController::class)->middleware('auth');
Route::resource('calendar', VacineCalendarController::class)->middleware('auth');