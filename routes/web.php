<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    if (class_exists(\App\Http\Controllers\SiteController::class)) {
        Route::resource('sites', SiteController::class);
    } else {
        Route::get('sites', fn() => abort(404))->name(name: 'sites.index');
        Route::get('sites/create', fn() => abort(404))->name('sites.create');
    }

    if (class_exists(\App\Http\Controllers\BlockController::class)) {
        Route::resource('blocks', BlockController::class);
    } else {
        Route::get('blocks', fn() => abort(404))->name('blocks.index');
        Route::get('blocks/create', fn() => abort(404))->name('blocks.create');
    }

    if (class_exists(\App\Http\Controllers\CustomerController::class)) {
        Route::resource('customers', CustomerController::class);
    } else {
        Route::get('customers', fn() => abort(404))->name('customers.index');
        Route::get('customers/create', fn() => abort(404))->name('customers.create');
    }
});

require __DIR__.'/auth.php';
