<?php

use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Added this routes so i can test via Postman since there is no frontend
 */
Route::post('/user/enroll/lesson', [UserController::class, 'enroll']);

Route::post('/user/comment', [UserController::class, 'comment']);

Route::post('/user/lesson/watched', [UserController::class, 'lessonWatched']);

Route::get('/user/{user}/achievements', [AchievementsController::class, 'index']);
