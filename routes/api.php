<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth']], function() {
    Route::post('/project', [ProjectController::class, 'create'])->name('project-create');
    Route::get('/project', [ProjectController::class, 'showAll'])->name('project-get-all');
    Route::get('/project/{id}', [ProjectController::class, 'showOne'])->name('project-get-one');

    Route::post('/message', [MessageController::class, 'send'])->name('message-create');
    Route::post('/message/{projectId}/{userId}', [MessageController::class, 'showAllWithUser'])->name('message-get-user-all');

    Route::get('/chats/{id}', [ChatController::class, 'showAllChats'])->name('chat-all');
});
