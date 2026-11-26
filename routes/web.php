<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminResourceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public site
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/resume/download', [PageController::class, 'resume'])->name('resume.download');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin panel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthController::class, 'store']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::get('/', [AdminResourceController::class, 'dashboard'])->name('dashboard');

        Route::get('{resource}', [AdminResourceController::class, 'index'])->name('resource.index');
        Route::get('{resource}/create', [AdminResourceController::class, 'create'])->name('resource.create');
        Route::post('{resource}', [AdminResourceController::class, 'store'])->name('resource.store');
        Route::get('{resource}/{id}/edit', [AdminResourceController::class, 'edit'])->name('resource.edit');
        Route::put('{resource}/{id}', [AdminResourceController::class, 'update'])->name('resource.update');
        Route::delete('{resource}/{id}', [AdminResourceController::class, 'destroy'])->name('resource.destroy');
    });
});
