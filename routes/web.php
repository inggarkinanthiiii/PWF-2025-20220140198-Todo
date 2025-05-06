<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    // 🔹 User - hanya bisa melihat daftar user (misalnya untuk role user biasa)
    Route::get('/users', [UserController::class, 'index'])->name('user.index');

    // 🔹 Rute Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔹 Rute Todo
    Route::resource('todo', TodoController::class)->except(['show']);
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/uncomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo/completed', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');
});

// Grup route untuk user yang memiliki akses admin
Route::middleware(['auth', 'admin'])->prefix('admin/users')->name('admin.users.')->group(function () {
    // 🔸 Kelola user: index, create, store, edit, update, destroy
    Route::get('/', [UserController::class, 'adminIndex'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

    // 🔸 Tambah / Hapus hak admin
    Route::patch('/{user}/makeadmin', [UserController::class, 'makeAdmin'])->name('makeAdmin');
    Route::patch('/{user}/removeadmin', [UserController::class, 'removeAdmin'])->name('removeAdmin');
});

// Route tambahan untuk otentikasi
require __DIR__ . '/auth.php';

// Fallback jika route tidak ditemukan
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
