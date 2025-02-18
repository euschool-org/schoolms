<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UccController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/ucc', [UccController::class, 'ucc'])->name('ucc');

Route::get('/test', [StudentController::class, 'test']);

