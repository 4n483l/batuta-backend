<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RehearsalController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TuitionController;
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

Route::middleware('auth:sanctum')->apiResource('rehearsals', RehearsalController::class);

/* Route::middleware('auth:sanctum')->get('/rehearsals', [RehearsalController::class, 'index']);
Route::middleware('auth:sanctum')->post('/rehearsals', [RehearsalController::class, 'store']);
Route::middleware('auth:sanctum')->get('/rehearsals/{id}', [RehearsalController::class, 'show']);
Route::middleware('auth:sanctum')->put('/rehearsals/{id}', [RehearsalController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/rehearsals/{id}', [RehearsalController::class, 'destroy']); */

Route::middleware('auth:sanctum')->get('/exams', [ExamController::class, 'index']);
Route::middleware('auth:sanctum')->post('/exams', [ExamController::class, 'store']);
Route::middleware('auth:sanctum')->get('/exams/{id}', [ExamController::class, 'show']);
Route::middleware('auth:sanctum')->put('/exams/{id}', [ExamController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/exams/{id}', [ExamController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/courses', [CourseController::class, 'index']);
Route::middleware('auth:sanctum')->post('/courses', [CourseController::class, 'store']);
Route::middleware('auth:sanctum')->get('/courses/{id}', [CourseController::class, 'show']);
Route::middleware('auth:sanctum')->put('/courses/{id}', [CourseController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/courses/{id}', [CourseController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/subjects', [SubjectController::class, 'index']);
Route::middleware('auth:sanctum')->post('/subjects', [SubjectController::class, 'store']);
Route::middleware('auth:sanctum')->get('/subjects/{id}', [SubjectController::class, 'show']);
Route::middleware('auth:sanctum')->put('/subjects/{id}', [SubjectController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/subjects/{id}', [SubjectController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/instruments', [InstrumentController::class, 'index']);
Route::middleware('auth:sanctum')->post('/instruments', [InstrumentController::class, 'store']);
Route::middleware('auth:sanctum')->get('/instruments/{id}', [InstrumentController::class, 'show']);
Route::middleware('auth:sanctum')->put('/instruments/{id}', [InstrumentController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/instruments/{id}', [InstrumentController::class, 'destroy']);

Route::middleware('auth:sanctum')->post('/tuitions', [TuitionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/tuitions', [TuitionController::class, 'show']);

Route::middleware('auth:sanctum')->get('/notes', [NoteController::class, 'index']);
Route::middleware('auth:sanctum')->post('/notes', [NoteController::class, 'store']);
Route::middleware('auth:sanctum')->get('/notes/{id}', [NoteController::class, 'show']);
Route::middleware('auth:sanctum')->put('/notes/{id}', [NoteController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/notes/{id}', [NoteController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/notes/subjectInstrument', [NoteController::class, 'getSubjectsAndInstruments']);


// garantiza que solo los usuarios autenticados puedan acceder a la ruta
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/user/students', [UserController::class, 'students']);

Route::middleware('auth:sanctum')->get('/teacher/subjects', [SubjectController::class, 'getTeacherSubjects']);
Route::middleware('auth:sanctum')->get('/teacher/instruments', [InstrumentController::class, 'getTeacherInstruments']);




