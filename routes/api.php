<?php

use App\Http\Controllers\APIPatientController;
use App\Http\Controllers\APIProvinceController;
use App\Http\Controllers\APIVacinatePatient;
use App\Http\Controllers\APIVacineCalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_patient_list/{region_id}/{province_id?}', [APIPatientController::class, 'getPatientList']);

Route::apiResources(['patient' => APIPatientController::class]);
Route::apiResources(['vacine_calendar' => APIVacineCalendarController::class]);
Route::apiResources(['vacinate_patient' => APIVacinatePatient::class]);
Route::apiResources(['api_provinces' => APIProvinceController::class]);
