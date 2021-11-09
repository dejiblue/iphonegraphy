<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::post('/user/enroll/lesson', [UserController::class, 'enroll']);

Route::post('/user/comment', [UserController::class, 'comment']);

Route::post('/user/lesson/watched', [UserController::class, 'lessonWatched']);

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);
