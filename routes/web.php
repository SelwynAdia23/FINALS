<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tickets', TicketController::class)->except(['edit']);
    Route::get('/tickets/attachments/{attachment}/download', [TicketController::class, 'downloadAttachment'])
        ->name('tickets.attachments.download');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::post('/users/{user}/role', [AdminController::class, 'assignRole'])->name('users.assign-role');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::get('/campuses', [AdminController::class, 'campuses'])->name('campuses');
        Route::put('/tickets/{ticket}', [AdminController::class, 'updateTicket'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [AdminController::class, 'deleteTicket'])->name('tickets.delete');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
