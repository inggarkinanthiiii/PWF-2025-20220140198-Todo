<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController; 
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Rute Todo
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store'); // Simpan
    Route::get('/todo/edit/{id}', [TodoController::class, 'edit'])->name('todo.edit'); // Edit
    Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update'); // Update
    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy'); // Hapus

    // ✅ Rute User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});

require __DIR__.'/auth.php';
