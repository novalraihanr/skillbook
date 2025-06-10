<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\LessonsPageController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::post('/courses/enroll-user', [CourseController::class, 'assign']);
    Route::get('/users/all/{id}', [UserController::class, 'showAll']);
    Route::get('/users/completed/{id}', [UserController::class, 'showCompleted']);
    Route::get('/users/all/completed/{id}', [UserController::class, 'showAllCompleted']);
    Route::post('/users/updatescore', [UserController::class, 'updateUserCourseScore']);

    Route::get('/courses/lessons/{id}', [CourseController::class, 'showAll']);
    Route::get('/users/rank', [UserController::class, 'rankStudentsWithTies']);
    Route::get('/users/rank/course/{id}', [CourseController::class, 'getCourseRanking']);
    Route::post('/courses/updateprogress', [CourseController::class, 'updateCourseProgress']);

    Route::get('lessons/{id}/page', [LessonsController::class, 'getPages']);
    Route::get('lessons/{id}/quiz', [LessonsController::class, 'getQuiz']);
    Route::post('lessons/update/{id}', [LessonsController::class, 'updateProgress']);
    Route::post('lessons/update/quiz/{id}', [LessonsController::class, 'updateQuizPage']);
});


Route::apiResources([
    'users' => UserController::class,
    'courses' => CourseController::class,
    'lessons' => LessonsController::class,
    'lessonspages' => LessonsPageController::class,
    'quizzes' => QuizController::class,
]);
