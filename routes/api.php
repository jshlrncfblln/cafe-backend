<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChurchProgramsController;
use App\Http\Controllers\LivelihoodProgramController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::get('/user' , [AuthController::class, 'user']);

    // USER MANAGEMENT
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // ORGANIZATION MANAGEMENT
    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'show']);
    Route::post('/organizations', [OrganizationController::class, 'create']);
    Route::put('/organizations/{id}', [OrganizationController::class, 'update']);
    Route::delete('/organizations/{id}', [OrganizationController::class, 'destroy']);

    // LIVELIHOOD MANAGEMENT
    Route::get('/livelihoods', [LivelihoodProgramController::class, 'index']);
    Route::get('/livelihoods/{id}', [LivelihoodProgramController::class, 'show']);
    Route::post('/livelihoods', [LivelihoodProgramController::class, 'create']);
    Route::put('/livelihoods/{id}', [LivelihoodProgramController::class, 'update']);
    Route::delete('/livelihoods/{id}', [LivelihoodProgramController::class, 'destroy']);

    // CHURCH PROGRAM MANAGEMENT
    Route::get('/church-programs', [ChurchProgramsController::class, 'index']);
    Route::get('/church-programs/{id}', [ChurchProgramsController::class, 'show']);
    Route::post('/church-programs', [ChurchProgramsController::class, 'create']);
    Route::put('/church-programs/{id}', [ChurchProgramsController::class, 'update']);
    Route::delete('/church-programs/{id}', [ChurchProgramsController::class, 'destroy']);

    // SURVEY MANAGEMENT
    Route::get('/surveys', [SurveyController::class, 'index']);
    Route::get('/surveys/{id}', [SurveyController::class, 'show']);
    Route::post('/surveys', [SurveyController::class, 'create']);
    Route::put('/surveys/{id}', [SurveyController::class, 'update']);
    Route::delete('/surveys/{id}', [SurveyController::class, 'destroy']);

    // STATISTICS
    Route::get('/statistics', [SurveyController::class, 'getStatistics']);
});