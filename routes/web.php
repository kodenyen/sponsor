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
    
    // User Management
    Route::resource('sponsors', AdminController::class . '@sponsors')->except(['show']);
    Route::get('/sponsors', [AdminController::class, 'sponsors'])->name('sponsors.index');
    Route::post('/sponsors', [AdminController::class, 'storeSponsor'])->name('sponsors.store');
    Route::get('/sponsors/{user}/edit', [AdminController::class, 'editSponsor'])->name('sponsors.edit');
    Route::put('/sponsors/{user}', [AdminController::class, 'updateSponsor'])->name('sponsors.update');
    Route::delete('/sponsors/{user}', [AdminController::class, 'destroySponsor'])->name('sponsors.destroy');
    Route::post('/sponsors/{user}/token', [AdminController::class, 'generateToken'])->name('sponsors.token');

    Route::get('/students', [AdminController::class, 'students'])->name('students.index');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{user}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{user}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{user}', [AdminController::class, 'destroyStudent'])->name('students.destroy');

    // Assignments
    Route::post('/assignments', [AdminController::class, 'assignStudent'])->name('assignments.store');
    Route::delete('/assignments/{sponsor}/{student}', [AdminController::class, 'removeAssignment'])->name('assignments.destroy');

    // Form Builder
    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::post('/forms', [FormController::class, 'store'])->name('forms.store');
    Route::delete('/forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');

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
    Route::get('/profile', [StudentController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::post('/messages/reply', [StudentController::class, 'replyMessage'])->name('messages.reply');
});
