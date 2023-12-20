<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ChartController;
use App\Http\Controllers\API\PhysicianController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PatientController;

Route::group(['prefix' => '/auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

Route::group(['prefix' => 'patient'], function () {
    Route::get('/concierge', [PatientController::class, 'concierge']);
    Route::get('/masterfile', [PatientController::class, 'masterfile']);
    Route::patch('/inactive/{id}', [PatientController::class, 'inactive']);
    Route::get('/report', [PatientController::class, 'report']);
    //chart
});

Route::group(['prefix' => 'chart'], function () {
    Route::post('/new/create', [ChartController::class, 'store']);
    Route::patch('/past/{id}', [ChartController::class, 'updatePastHistory']);
    Route::patch('/family/{id}', [ChartController::class, 'updateFamilyHistory']);
    Route::patch('/social/{id}', [ChartController::class, 'updateSocialHistory']);
    Route::patch('/patient/{id}', [ChartController::class, 'updatePatient']);
    Route::patch('/consultation/{id}', [ChartController::class, 'updateConsultation']);
    Route::patch('/vital/{id}', [ChartController::class, 'updateVitalSigns']);
    Route::post('/old/create', [ChartController::class, 'createExistingPatient']);
});

Route::group(['prefix' => 'physician'], function () {
    Route::post('/create', [PhysicianController::class, 'store']);
    Route::put('/{id}', [PhysicianController::class, 'update']);
    Route::patch('/inactive/{id}', [PhysicianController::class, 'inactive']);
    Route::patch('/active/{id}', [PhysicianController::class, 'active']);
    Route::get('/all', [PhysicianController::class, 'all']);
    Route::get('/', [PhysicianController::class, 'index']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'store']);
    Route::patch('/{id}', [UserController::class, 'update']);
});
