<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DashboardAccessController;
use App\Http\Controllers\DashboardPreviewController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PortfolioDashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::middleware('guest')->group(function (): void {
	Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
	Route::get('/access/request', [DashboardAccessController::class, 'showRequestForm'])->name('access.request.form');
	Route::post('/access/request', [DashboardAccessController::class, 'submitRequest'])->name('access.request.submit');
	Route::get('/access/key', [DashboardAccessController::class, 'showKeyForm'])->name('access.key.form');
	Route::post('/access/key', [DashboardAccessController::class, 'verifyKey'])->name('access.key.verify');
});

Route::middleware('auth')->group(function (): void {
	Route::get('/dashboard', [PortfolioDashboardController::class, 'edit'])->name('dashboard');
	Route::put('/dashboard', [PortfolioDashboardController::class, 'update'])->name('dashboard.update');

	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function (): void {
	Route::put('/dashboard/access-requests/{accessRequest}/approve', [DashboardAccessController::class, 'approve'])->name('access.approve');
	Route::put('/dashboard/access-requests/{accessRequest}/reject', [DashboardAccessController::class, 'reject'])->name('access.reject');
});

Route::get('/dashboard/preview', [DashboardPreviewController::class, 'index'])
	->middleware('dashboard.preview')
	->name('dashboard.preview');

Route::post('/access/logout-temp', [DashboardAccessController::class, 'clearTemporarySession'])
	->name('access.session.clear');

Route::middleware(['auth', 'admin'])->group(function (): void {
	Route::resource('users', UserController::class)->except('show');
});
