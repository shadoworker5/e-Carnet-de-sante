<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PatientVacinateController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegionsController;
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


Route::get('/verify-status', function () {
    return view('verify-status');
})->name('verify_status');

Route::get('/offline', function(){
    return view('offlines.offline');
});
Route::get('/list_vacinate', [PagesController::class, 'offlineSubmission'])->middleware('auth')->name('offline_submission');
Route::get('/offline_vacinate', [PagesController::class, 'offlineForm'])->middleware('auth')->name('offline_form');
Route::get('/offline_show', [PagesController::class, 'offlineShow'])->middleware('auth')->name('offline_show_patient');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/home', [PagesController::class, 'index'])->name('home');
    Route::get('/profile', [PagesController::class, 'profile'])->name('profile');
});

Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/list_user', [AdminController::class, 'listUser'])->name('list_user');
    Route::get('/seting', [AdminController::class, 'setings'])->name('setings');
    Route::resource('update_user', UserController::class);
});


Route::resource('patient', PatientsController::class)->middleware(['auth']);
Route::resource('vaccinate', PatientVacinateController::class)->middleware('auth');
Route::resource('calendar', VacineCalendarController::class)->middleware(['auth']);
Route::resource('regions', RegionsController::class)->middleware(['auth']);
Route::resource('provinces', ProvinceController::class)->middleware(['auth']);

Route::get('/add_vacinate/{id}', [PatientVacinateController::class, 'addVacinate'])->middleware('auth')->name('add_vacination');