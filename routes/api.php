<?php

use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use Illuminate\Support\Facades\Route;

Route::get('/portfolio', [PortfolioApiController::class, 'show']);
Route::post('/contact', [ContactApiController::class, 'store'])
	->middleware('throttle:contact-api');
