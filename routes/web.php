<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\ChatSiswaController;
use App\Http\Controllers\ChatGuruController;
use App\Http\Controllers\GuruInboxController;
use Illuminate\Support\Facades\Broadcast;


Route::get('/', [AuthLoginController::class, 'showLogin'])->name('login');
Route::post('/', [AuthLoginController::class, 'login']);
Route::get('/logout', [AuthLoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->prefix('siswa')->group(function () {
    // Dashboard siswa
    Route::get('/dashboard', function () {
        return view('SiswaPage/DashboardSiswa');
    })->name('siswa.dashboard');

    // Fitur chat siswa
    Route::get('/chat/guru', [ChatSiswaController::class, 'listGuru'])->name('chat.guru.list');
    Route::get('/chat/with/{guruId}', [ChatSiswaController::class, 'chatWithGuru'])->name('chat.with');
    Route::post('/chat/send/{conversationId}', [ChatSiswaController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/load/{conversationId}', [ChatSiswaController::class, 'loadMessages'])->name('chat.load');
});


Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    // Dashboard guru
    Route::get('/dashboard', function () {
        return view('GuruPage/DashboardGuru');
    })->name('guru.dashboard');

    // Chat dengan siswa
    Route::get('/chat/{conversationId}', [ChatGuruController::class, 'showChat'])->name('guru.chat.show');
    Route::post('/chat/{conversationId}/send', [ChatGuruController::class, 'sendMessage'])->name('guru.chat.send');
    Route::get('/chat/load/{conversationId}', [ChatGuruController::class, 'loadMessages'])->name('guru.chat.load');
    Route::get('/inbox', [GuruInboxController::class, 'index'])->name('guru.inbox');
});


Broadcast::routes(['middleware' => ['web', 'auth:guru,siswa']]);
