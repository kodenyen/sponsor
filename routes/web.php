<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Token access
Route::get('/sponsor/access', [SponsorController::class, 'tokenAccess'])->name('sponsor.access');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::post('/messages/{message}/approve', [AdminController::class, 'approveMessage'])->name('messages.approve');
    Route::post('/messages/{message}/reject', [AdminController::class, 'rejectMessage'])->name('messages.reject');
});

Route::middleware(['auth', 'sponsor'])->prefix('sponsor')->name('sponsor.')->group(function () {
    Route::get('/dashboard', [SponsorController::class, 'dashboard'])->name('dashboard');
    Route::post('/messages/send', [SponsorController::class, 'sendMessage'])->name('messages.send');
});

Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::post('/messages/reply', [StudentController::class, 'replyMessage'])->name('messages.reply');
});
