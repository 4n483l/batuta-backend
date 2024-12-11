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

/* *** REGISTRO *** */
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

/* *** CONCIERTOS *** */
Route::get('/concerts', [ConcertController::class, 'index']);
Route::middleware('auth:sanctum')->apiResource( 'concerts', ConcertController::class)->except('index');

/* *** ENSAYOS *** */
Route::middleware('auth:sanctum')->apiResource('rehearsals', RehearsalController::class);

/* *** EXÁMENES *** */
Route::middleware('auth:sanctum')->apiResource('exams', ExamController::class);

/* *** CLASES *** */
Route::middleware('auth:sanctum')->apiResource( 'courses', CourseController::class);

/* *** ASIGNATURAS *** */
Route::middleware('auth:sanctum')->apiResource('subjects', SubjectController::class);

/* *** INSTRUMENTOS *** */
Route::middleware('auth:sanctum')->apiResource('instruments', InstrumentController::class);

/* *** APUNTES *** */
Route::middleware('auth:sanctum')->get('/notes/subjectInstrument', [NoteController::class, 'getSubjectsAndInstruments']);

Route::middleware('auth:sanctum')->apiResource('notes', NoteController::class);


/* *** MATRICULA *** */
Route::middleware('auth:sanctum')->post('/tuitions', [TuitionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/tuitions', [TuitionController::class, 'show']);

/* *** USUARIOS *** */
Route::middleware('auth:sanctum')->apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->get('/user/students', [UserController::class, 'getStudentsAssociate']);

/* *** NAVBAR *** */
Route::middleware('auth:sanctum')->get('/navbar', [UserController::class, 'getNavbar']);

/* *** ESTUDIANTES *** */
Route::middleware('auth:sanctum')->get('/students', [UserController::class, 'indexStudents']);
Route::middleware('auth:sanctum')->get('/students/{id}', [UserController::class, 'showStudent']);
Route::middleware('auth:sanctum')->post('/students', [UserController::class, 'storeStudent']);
Route::middleware('auth:sanctum')->put('/students/{id}', [UserController::class, 'updateStudent']);
Route::middleware('auth:sanctum')->delete('/students/{id}', [UserController::class, 'destroyStudent']);

/* *** PROFESORES *** */
Route::middleware('auth:sanctum')->get('/teachers', [UserController::class, 'indexTeachers']);


Route::middleware('auth:sanctum')->get('/teacher/subjects', [SubjectController::class, 'getTeacherSubjects']);
Route::middleware('auth:sanctum')->get('/teacher/instruments', [InstrumentController::class, 'getTeacherInstruments']);




