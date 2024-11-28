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
// Route::get('/concerts', [ConcertController::class, 'index']);
// Route::post('/concerts', [ConcertController::class, 'store']);

Route::get('/rehearsals', [RehearsalController::class, 'index']);
Route::get('/exams', [ExamController::class, 'index']);
Route::get('/courses', [ CourseController::class, 'index']);


Route::get('/subjects', [SubjectController::class, 'index']);
Route::get('/instruments', [InstrumentController::class, 'index']);


// garantiza que solo los usuarios autenticados puedan acceder a la ruta
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/teacher/subjects', [SubjectController::class, 'getTeacherSubjects']);
Route::middleware('auth:sanctum')->get('/teacher/instruments', [SubjectController::class, 'getTeacherInstruments']);



Route::middleware('auth:sanctum')->post('/tuitions', [TuitionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/tuitions', [TuitionController::class, 'show']);
Route::middleware('auth:sanctum')->post('/notes', [NoteController::class, 'store']);


Route::get('/notes', [NoteController::class, 'index']);


