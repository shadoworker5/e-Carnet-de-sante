<?php

use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/offline', function(){
    return view('offlines.offline');
});
Route::get('/list_vacinate', function(){
    return view('offlines.list_vacinate');
})->middleware('auth')->name('offline_submission');

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/home', [PagesController::class, 'index'])->name('home');
    Route::get('/profile', [PagesController::class, 'profile'])->name('profile');
});

Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/list_user', [AdminController::class, 'listUser'])->name('list_user');
});

// Route::resource('guest', PagesController::class)->middleware('auth');

Route::resource('patient', PatientsController ::class)->middleware(['auth']);
Route::resource('vaccinate', PatientVacinateController::class)->middleware('auth');
Route::resource('calendar', VacineCalendarController::class)->middleware(['auth', 'authadmin']);