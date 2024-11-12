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

// RUTAS PUBLICAS
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/concerts', [ConcertController::class, 'index']);
Route::get('/exams', [ExamController::class, 'index']);
Route::get('/courses', [ CourseController::class, 'index']);


// RUTAS PRIVADAS
// garantiza que solo los usuarios autenticados puedan acceder a la ruta
Route::middleware('auth:sanctum')->post('/tuitions', [TuitionController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// rutas que aun no sé si serán públicas o privadas

Route::get('/tuitions', [TuitionController::class, 'show']);
Route::get('/rehearsals', [RehearsalController::class, 'index']);

/*
Route::get('/notes', [NotesController::class, 'index']);
 */

