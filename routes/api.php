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

/* Route::middleware('auth:sanctum')->get('/exams', [ExamController::class, 'index']);
Route::middleware('auth:sanctum')->post('/exams', [ExamController::class, 'store']);
Route::middleware('auth:sanctum')->get('/exams/{id}', [ExamController::class, 'show']);
Route::middleware('auth:sanctum')->put('/exams/{id}', [ExamController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/exams/{id}', [ExamController::class, 'destroy']); */

/* *** CLASES *** */
Route::middleware('auth:sanctum')->apiResource( 'courses', CourseController::class);

/* Route::middleware('auth:sanctum')->get('/courses', [CourseController::class, 'index']);
Route::middleware('auth:sanctum')->post('/courses', [CourseController::class, 'store']);
Route::middleware('auth:sanctum')->get('/courses/{id}', [CourseController::class, 'show']);
Route::middleware('auth:sanctum')->put('/courses/{id}', [CourseController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/courses/{id}', [CourseController::class, 'destroy']); */

/* *** ASIGNATURAS *** */
Route::middleware('auth:sanctum')->apiResource('subjects', SubjectController::class);

/* *** INSTRUMENTOS *** */
Route::middleware('auth:sanctum')->apiResource('instruments', InstrumentController::class);


/* *** APUNTES *** */
Route::middleware('auth:sanctum')->get('/notes/subjectInstrument', [NoteController::class, 'getSubjectsAndInstruments']);
Route::middleware('auth:sanctum')->apiResource( 'notes', NoteController::class);

/* Route::middleware('auth:sanctum')->get('/notes', [NoteController::class, 'index']);
Route::middleware('auth:sanctum')->post('/notes', [NoteController::class, 'store']);
Route::middleware('auth:sanctum')->get('/notes/{id}', [NoteController::class, 'show']);
Route::middleware('auth:sanctum')->put('/notes/{id}', [NoteController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/notes/{id}', [NoteController::class, 'destroy']); */


/* *** MATRICULA *** */
Route::middleware('auth:sanctum')->post('/tuitions', [TuitionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/tuitions', [TuitionController::class, 'show']);

/* *** USUARIOS *** */
Route::middleware('auth:sanctum')->apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->get('/user/students', [UserController::class, 'getStudentsAssociate']);

/* *** ESTUDIANTES *** */
Route::middleware('auth:sanctum')->get('/students', [UserController::class, 'indexStudents']);
Route::middleware('auth:sanctum')->get('/students/{id}', [UserController::class, 'showStudent']);
Route::middleware('auth:sanctum')->post('/students', [UserController::class, 'storeStudent']);
Route::middleware('auth:sanctum')->put('/students/{id}', [UserController::class, 'updateStudent']);
Route::middleware('auth:sanctum')->delete('/students/{id}', [UserController::class, 'destroyStudent']);



Route::middleware('auth:sanctum')->get('/teacher/subjects', [SubjectController::class, 'getTeacherSubjects']);
Route::middleware('auth:sanctum')->get('/teacher/instruments', [InstrumentController::class, 'getTeacherInstruments']);

/* *** RUTAS PARA EL ADMIN *** */
/* Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('admin/concerts-admin', ConcertController::class);
    Route::apiResource('admin/rehearsals', RehearsalController::class);
    Route::apiResource('admin/exams', ExamController::class);
    Route::apiResource('admin/courses', CourseController::class);
    Route::apiResource('admin/subjects', SubjectController::class);
    Route::apiResource('admin/instruments', InstrumentController::class);
    Route::apiResource('admin/notes', NoteController::class);
    Route::apiResource('admin/users', UserController::class);
    Route::apiResource('admin/tuitions', TuitionController::class);

    // Otras rutas específicas del administrador
    Route::get('admin/teacher/subjects', [SubjectController::class, 'getTeacherSubjects']);
    Route::get('admin/teacher/instruments', [InstrumentController::class, 'getTeacherInstruments']);
});
 */




