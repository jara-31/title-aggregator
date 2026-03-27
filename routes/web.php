<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AggregatorController;

Route::get('/', [AggregatorController::class, 'index'])->name('home');
Route::get('/refresh', [AggregatorController::class, 'refresh'])->name('refresh');