<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginController;



Route::get('/', [AuthLoginController::class, 'showLogin'])->name('login');
Route::post('/', [AuthLoginController::class, 'login']);
Route::get('/logout', [AuthLoginController::class, 'logout'])->name('logout');


Route::get('/siswa/dashboard', function () {
    return view('SiswaPage/DashboardSiswa');
})->middleware('auth')->name('siswa.dashboard');

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', function () {
        return view('GuruPage/DashboardGuru');
    })->name('guru.dashboard');
});