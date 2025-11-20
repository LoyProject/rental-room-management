<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
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
    Route::get('/customers-by-block/{block_id}', [CustomerController::class, 'getByBlock']);
    Route::get('/customer-info/{id}', [CustomerController::class, 'getCustomerInfo']);
    Route::get('/block-info/{id}', [BlockController::class, 'getBlockInfo']);

    Route::resource('sites', SiteController::class);
    Route::resource('blocks', BlockController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('users', UserController::class);
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::resource('invoices', InvoiceController::class);
});

require __DIR__.'/auth.php';
