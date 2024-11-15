<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class);

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('tasks', TaskController::class);

Route::put('/tasks/{id}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');

// Доступ до цих маршрутів лише для адміністратора
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/tasks', [TaskController::class, 'adminTasks'])->name('admin.tasks');
});

// Доступ до цих маршрутів лише для гостей
Route::middleware(['role:guest'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
