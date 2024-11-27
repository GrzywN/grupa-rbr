<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskHistoryController;
use App\Http\Controllers\TaskHistoryEventController;
use App\Http\Controllers\TaskPriorityController;
use App\Http\Controllers\TaskSharingController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('auth/register'))->middleware('guest');

Route::get('/dashboard', fn () => Inertia::render('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(static function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/tasks')->group(static function (): void {

        Route::controller(TaskController::class)->group(static function (): void {
            Route::get('/', 'index')->name('tasks.index');
            Route::post('/', 'store')->name('tasks.store');
            Route::get('/{task}', 'show')->name('tasks.show');
            Route::put('/{task}', 'update')->name('tasks.update');
            Route::delete('/{task}', 'destroy')->name('tasks.destroy');
        });

        Route::controller(TaskHistoryController::class)->group(static function (): void {
            Route::get('/{task}/history', 'index')->name('task-history.index');
        });

        Route::controller(TaskSharingController::class)->group(static function (): void {
            Route::get('/{task}/shares', 'index')->name('tasks.shares.index');
            Route::post('/{task}/shares', 'store')->name('tasks.shares.store');
            Route::delete('/{task}/shares/{token}', 'destroy')->name('tasks.shares.destroy');
        });
    });

    Route::get('/task-history-events', TaskHistoryEventController::class)->name('task-history-events.index');
});

Route::prefix('external')->group(static function (): void {
    Route::get('/tasks/{token}', [TaskSharingController::class, 'show'])->name('tasks.shared');

    Route::get('/task-priorities', TaskPriorityController::class)->name('task-priorities.index');

    Route::get('/task-statuses', TaskStatusController::class)->name('task-statuses.index');
});

require __DIR__.'/auth.php';
