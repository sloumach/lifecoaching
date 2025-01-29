<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('index');
})->name('welcome');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:2,1')->name('contact.store');


/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/inbox', [ProfileController::class, 'inbox'])->name('dashboard');
    Route::delete('/admin/inbox/delete/{id}', [ProfileController::class, 'deleteMessage'])->name('admin.deleteMessage');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
