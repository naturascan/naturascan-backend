<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\BirdController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DechetController;
use App\Http\Controllers\EspeceController;
use App\Http\Controllers\EtapeController;
use App\Http\Controllers\GpsTrackController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\PointDePassageController;
use App\Http\Controllers\SortieController;
use App\Http\Controllers\SortieNaturascanController;
use App\Http\Controllers\SortieObstraceController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\WeatherReportController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ObservateurController;
use App\Http\Controllers\ExportController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// password
Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('updatePassword', [AuthController::class, 'updatePassword']);
Route::post('/refreshToken', [AuthController::class, 'refreshToken']);

Route::group(["middleware" => 'auth:sanctum'],function() {
    Route::get('export', [ExportController::class, 'export']);
    // refresh token
    Route::get('/export-excel', [ExportController::class, 'exportExcel']);

    Route::get('me', [AuthController::class, 'me']);

    Route::post('/sync', [SyncController::class, 'sync']);
 
    Route::apiResource('animals', AnimalController::class);
    Route::apiResource('birds', BirdController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('dechets', DechetController::class);
    Route::apiResource('especes', EspeceController::class);
    Route::apiResource('etapes', EtapeController::class);
    Route::apiResource('gpstracks', GpsTrackController::class);
    Route::apiResource('observations', ObservationController::class);
    Route::apiResource('point_de_passages', PointDePassageController::class);
    Route::apiResource('sorties', SortieController::class);
    Route::apiResource('sorties_naturascan', SortieNaturascanController::class);
    Route::apiResource('sorties_obstrace', SortieObstraceController::class);
    Route::apiResource('wastes', WasteController::class);
    Route::apiResource('weather_reports', WeatherReportController::class);
    Route::apiResource('zones', ZoneController::class);
    Route::apiResource('observateurs', ObservateurController::class);
    Route::apiResource('exports', ExportController::class);


    
    // get observers 
    Route::get('observers', [AuthController::class, 'observers']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // delete my account
    Route::delete('/delete-account', [AuthController::class, 'deleteAccount']);


    
});