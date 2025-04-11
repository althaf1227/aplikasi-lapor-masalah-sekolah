<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatGuruController;
use App\Http\Controllers\GuruInboxController;


Route::get('/', [AuthLoginController::class, 'showLogin'])->name('login');
Route::post('/', [AuthLoginController::class, 'login']);
Route::get('/logout', [AuthLoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->prefix('siswa')->group(function () {
    // Dashboard siswa
    Route::get('/dashboard', function () {
        return view('SiswaPage/DashboardSiswa');
    })->name('siswa.dashboard');

    // Fitur chat siswa
    Route::get('/chat/guru', [ChatController::class, 'listGuru'])->name('chat.guru.list');
    Route::get('/chat/with/{guruId}', [ChatController::class, 'chatWithGuru'])->name('chat.with');
    Route::post('/chat/send/{conversationId}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/load/{conversationId}', [ChatController::class, 'loadMessages'])->name('chat.load');
});


Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    // Dashboard guru
    Route::get('/dashboard', function () {
        return view('GuruPage/DashboardGuru');
    })->name('guru.dashboard');

    // Chat dengan siswa
    Route::get('/chat/{conversationId}', [ChatGuruController::class, 'showChat'])->name('guru.chat.show');
    Route::post('/chat/{conversationId}/send', [ChatGuruController::class, 'sendMessage'])->name('guru.chat.send');
    Route::get('/inbox', [GuruInboxController::class, 'index'])->name('guru.inbox');
});



