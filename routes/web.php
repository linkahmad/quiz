<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [QuizController::class, 'showNameForm']);
Route::post('/start-quiz', [QuizController::class, 'startQuiz']);
Route::post('/get-question', [QuizController::class, 'getQuestion']);
Route::post('/submit-answer', [QuizController::class, 'submitAnswer']);
Route::get('/results/{userId}', [QuizController::class, 'results']);
