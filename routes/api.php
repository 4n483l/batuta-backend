<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConcertsController;
use App\Http\Controllers\RehearsalsController;
use App\Http\Controllers\TuitionsController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\NotesController;



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

// Route::post('/tuitions', [TuitionsController::class, 'store']);

// garantiza que solo los usuarios autenticados puedan acceder a la ruta
 Route::middleware('auth:sanctum')->post('/tuitions', [TuitionsController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 Route::get('/tuitions', [TuitionsController::class, 'show']);

Route::get('/concerts', [ConcertsController::class, 'index']);
Route::get('/rehearsals', [RehearsalsController::class, 'index']);

/* Route::get('/classes', [ClassesController::class, 'index']);
Route::get('/exams', [ExamsController::class, 'index']);
Route::get('/notes', [NotesController::class, 'index']);
 */

