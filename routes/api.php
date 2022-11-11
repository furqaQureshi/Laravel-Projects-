<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DisclaimerController;
use App\Http\Controllers\Api\ChatController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/forgot-password/verify', [UserController::class, 'forgotPasswordVerify']);
Route::get('/disclaimer', [DisclaimerController::class, 'index']);

Route::group(['middleware' => ['jwt.auth']], function ($router) {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/user/add-device-id', [AuthController::class, 'addDeviceId']);
    Route::post('/user/update-profile', [AuthController::class, 'updateUserProfile']);
    Route::post('/user/disclaimer-update', [AuthController::class, 'updateUserDisclaimer']);
    Route::post('/user/update-password', [AuthController::class, 'updatePassword']);

    //courses section
    Route::get('/courses', [CourseController::class, 'index']); // not in use
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/module/{module_id}', [CourseController::class, 'showModule']); // not in use
    Route::post('/module/{module_id}/progress', [CourseController::class, 'updateModuleProgress']);
	Route::get('/module/{module_id}/quiz', [CourseController::class, 'showModuleQuiz']);
	Route::post('/module/{module_id}/quiz/save', [CourseController::class, 'saveModuleQuiz']);

    // chat section
    Route::get('/chat', [ChatController::class, 'index']);
    Route::post('/chat', [ChatController::class, 'store']);

});
