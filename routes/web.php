<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('feed');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\PageController::class, 'feed'])->name('feed');
    Route::get('/feed', [App\Http\Controllers\PageController::class, 'feed'])->name('feed');
    Route::get('/photo', [App\Http\Controllers\PageController::class, 'photo'])->name('photo');
    Route::get('/video', [App\Http\Controllers\PageController::class, 'video'])->name('video');

    Route::post('/like', [App\Http\Controllers\PageController::class, 'changeLike'])->name('changeLike');

    Route::get('/new-post', [App\Http\Controllers\PostController::class, 'index'])->name('new-post');
    Route::post('/new-post', [App\Http\Controllers\PostController::class, 'savePost'])->name('savePost');
    Route::post('/new-comment', [App\Http\Controllers\PostController::class, 'saveComment'])->name('saveComment');
    Route::post('/delete-post', [App\Http\Controllers\PostController::class, 'deletePost'])->name('deletePost');
    Route::post('/block-post', [App\Http\Controllers\PostController::class, 'blockPost'])->name('blockPost');
    Route::post('/unblock-post', [App\Http\Controllers\PostController::class, 'unblockPost'])->name('unblockPost');

    Route::get('/quiz', [App\Http\Controllers\AnswerController::class, 'quiz'])->name('quiz');
    Route::put('/add-quiz', [App\Http\Controllers\AnswerController::class, 'addQuiz'])->name('addQuiz');
    Route::post('/delete-quiz', [App\Http\Controllers\AnswerController::class, 'deleteQuiz'])->name('deleteQuiz');
    Route::put('/edit-quiz', [App\Http\Controllers\AnswerController::class, 'editQuiz'])->name('editQuiz');
    Route::post('/state-quiz', [App\Http\Controllers\AnswerController::class, 'stateQuiz'])->name('stateQuiz');
    Route::post('/save-answer', [App\Http\Controllers\AnswerController::class, 'saveAnswer'])->name('saveAnswer');

    Route::get('/answer/{id}', [App\Http\Controllers\AnswerController::class, 'answer'])->name('answer');
    Route::get('/answers', [App\Http\Controllers\AnswerController::class, 'answers'])->name('answers');
});
