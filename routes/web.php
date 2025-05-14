<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (untuk user yang login & verifikasi email)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup route untuk user yang login
Route::middleware(['auth', 'verified'])->group(function () {

    // 🔹 Rute Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔹 Rute Todo
    Route::resource('todo', TodoController::class)->except(['show']);
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/uncomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo/completed', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');

    // 🔹 Rute User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::resource('user', UserController::class);


        // 🔸 Make / Remove Admin
        Route::patch('/{user}/makeadmin', [UserController::class, 'makeAdmin'])->name('user.makeAdmin');
        Route::patch('/{user}/removeadmin', [UserController::class, 'removeAdmin'])->name('user.removeAdmin');
        Route::resource('category', CategoryController::class);
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');



        // Menambahkan route yang Anda berikan (perhatikan penempatannya)
        // Route::get('/user/makeadmin', [UserController::class, 'makeAdmin'])->name('user.makeadmin');
    });
});

// Route tambahan untuk otentikasi
require __DIR__ . '/auth.php';

// Fallback jika route tidak ditemukan
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});