<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->controller(StudentController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/students/form', 'form')->name('student.create');
    Route::get('/students/form/{student?}', 'form')->name('student.edit');
    Route::post('/students', [StudentController::class, 'store'])->name('student.store');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/students/{student}', 'destroy')->name('student.destroy');
});

Route::post('/language-switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
