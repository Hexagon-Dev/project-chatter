<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/project', [ProjectController::class, 'showAll'])->name('project-get-all');
    Route::get('/project/{id}', [ProjectController::class, 'showOne'])->name('project-get-one');

    Route::post('/message/{projectId}/{userId}', [MessageController::class, 'send'])->name('message-send');
    Route::get('/message/{messageId}', [MessageController::class, 'showOne'])->name('message-get-sender-one');
    Route::get('/message/{projectId}/{userId}', [MessageController::class, 'showAllWithUser'])->name('message-get-sender-all');
    Route::get('/message/{projectId}', [MessageController::class, 'showAllInProject'])->name('message-get-project-all');
});
