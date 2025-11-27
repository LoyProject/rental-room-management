<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/customers-by-block/{block_id}', [CustomerController::class, 'getByBlock']);
    Route::get('/customer-info/{id}', [CustomerController::class, 'getCustomerInfo']);
    Route::get('/block-info/{id}', [BlockController::class, 'getBlockInfo']);
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('/blocks-by-site/{site_id}', [BlockController::class, 'getBlocksBySite']);
    Route::get('/default-date-by-site/{site_id}', [BlockController::class, 'getDateBySite']);

    Route::resource('invoices', InvoiceController::class);
    Route::resource('blocks', BlockController::class);
    Route::resource('customers', CustomerController::class);
    
    Route::get('/api/chart/monthly-revenue', [DashboardController::class, 'getMonthlyRevenueData'])
        ->name('api.chart.monthly-revenue');
    Route::get('/api/chart/monthly-revenue/{year}', [DashboardController::class, 'getMonthlyRevenueByYear'])
        ->name('api.chart.monthly-revenue.year');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('sites', SiteController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
