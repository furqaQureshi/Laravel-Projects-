
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewCourse;
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
    return view('auth.login');
});


Auth::routes();

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Customer Routes
Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index']);
Route::post('/customers', [\App\Http\Controllers\CustomerController::class, 'store']);
//create 
Route::get('/customers/create', [\App\Http\Controllers\CustomerController::class, 'create']);

Route::get('/customers/{id}/update-status/{status}', [\App\Http\Controllers\CustomerController::class, 'updateStatus']);
Route::get('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'edit']);
Route::post('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'update']);
Route::post('/customers/{id}/update-password', [\App\Http\Controllers\CustomerController::class, 'updatePassword']);

//  User Routes
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create']);
Route::get('/users/{id}/update-status/{status}', [\App\Http\Controllers\UserController::class, 'updateStatus']);
Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'edit']);
Route::post('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
Route::post('/users/{id}/update-password', [\App\Http\Controllers\UserController::class, 'updatePassword']);

//  Course Routes
Route::get('/courses', [\App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [\App\Http\Controllers\CourseController::class, 'create']);
Route::post('/course', [\App\Http\Controllers\CourseController::class, 'store']);
Route::get('/course/edit/{id}', [\App\Http\Controllers\CourseController::class, 'edit']);
Route::put('/courses/{id}', [\App\Http\Controllers\CourseController::class, 'update']);

Route::get('/courses/{id}', [\App\Http\Controllers\CourseController::class, 'show']);

Route::get('/courses/{id}/modules/create', [\App\Http\Controllers\CourseController::class, 'createModule'])->name('module.create');
Route::put('/courses/{course_id}/module/add', [\App\Http\Controllers\CourseController::class, 'addModule']);


Route::get('/courses/{course_id}/module/{module_id}', [\App\Http\Controllers\CourseController::class, 'showModules']);
Route::post('/courses/{course_id}/module/{module_id}', [\App\Http\Controllers\CourseController::class, 'updateModule']);
Route::get('/courses/{course_id}/module/{module_id}/quiz', [\App\Http\Controllers\CourseController::class, 'showModuleQuiz']);
Route::post('/courses/{course_id}/module/{module_id}/quiz', [\App\Http\Controllers\CourseController::class, 'addModuleQuiz']);
Route::get('/courses/{course_id}/module/{module_id}/quiz/{quiz_id}/delete', [\App\Http\Controllers\CourseController::class, 'deleteModuleQuiz']);



// Disclaimer Routes
Route::get('/disclaimers', [\App\Http\Controllers\DisclaimerController::class, 'index']);
Route::post('/disclaimers', [\App\Http\Controllers\DisclaimerController::class, 'store']);
Route::get('/disclaimers/create', [\App\Http\Controllers\DisclaimerController::class, 'create']);
Route::get('/disclaimers/{id}/edit', [\App\Http\Controllers\DisclaimerController::class, 'edit']);
Route::post('/disclaimers/{id}/update', [\App\Http\Controllers\DisclaimerController::class, 'update']);
Route::get('/disclaimers/{id}/status/{status}', [\App\Http\Controllers\DisclaimerController::class, 'updateStatus']);


// Announcements Routes
Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index']);
Route::post('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'store']);
Route::get('/announcements/create', [\App\Http\Controllers\AnnouncementController::class, 'create']);

// Q&A Routes
Route::Get('/Q_A', [\App\Http\Controllers\QAController::class, 'index']);
Route::post('/Q_A', [\App\Http\Controllers\QAController::class, 'store']);
Route::get('/Q_A/create', [\App\Http\Controllers\QAController::class, 'create']);
Route::get('/Q_A/{id}/edit', [\App\Http\Controllers\QAController::class, 'edit']);
Route::post('/Q_A/{id}/update', [\App\Http\Controllers\QAController::class, 'update']);


Route::get('/chats', [\App\Http\Controllers\ChatController::class, 'index']);
Route::post('/chats', [\App\Http\Controllers\ChatController::class, 'store']);
Route::get('/chats/{id}', [\App\Http\Controllers\ChatController::class, 'getChatRecords']);
Route::get('/chats/new-messages/count', [\App\Http\Controllers\ChatController::class, 'getNewChatNotification']);


