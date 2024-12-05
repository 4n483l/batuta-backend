<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\RehearsalController;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\UserController;



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


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::apiResource('concerts', ConcertController::class);



Route::apiResource('rehearsals', RehearsalController::class) ;
// Route::get('/rehearsals', [RehearsalController::class, 'index']);


Route::get('/exams', [ExamController::class, 'index']);
Route::get('/courses', [ CourseController::class, 'index']);

Route::apiResource('subjects', SubjectController::class);
// Route::get('/subjects', [SubjectController::class, 'index']);

 Route::apiResource('instruments', InstrumentController::class);
/*  Route::get('/instruments', [InstrumentController::class, 'index']);
Route::get('instruments/{id}', [InstrumentController::class, 'show']);
 Route::post('/instruments', [InstrumentController::class, 'store']);
Route::put('instruments/{id}', [InstrumentController::class, 'update']);
Route::delete('instruments/{id}', [InstrumentController::class, 'destroy']); */

Route::apiResource('courses', CourseController::class);


// garantiza que solo los usuarios autenticados puedan acceder a la ruta
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/user/students', [UserController::class, 'students']);



Route::middleware('auth:sanctum')->get('/teacher/subjects', [SubjectController::class, 'getTeacherSubjects']);
Route::middleware('auth:sanctum')->get('/teacher/instruments', [InstrumentController::class, 'getTeacherInstruments']);



Route::middleware('auth:sanctum')->post('/tuitions', [TuitionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/tuitions', [TuitionController::class, 'show']);


Route::middleware('auth:sanctum')->get('/notes', [NoteController::class, 'index']);
Route::middleware('auth:sanctum')->post('/notes', [NoteController::class, 'store']);
Route::middleware('auth:sanctum')->get( '/notes/subjectInstrument', [NoteController::class, 'getSubjectsAndInstruments']);




