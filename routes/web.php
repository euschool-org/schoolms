<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
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
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->controller(StudentController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/students/form', 'form')->name('student.create');
    Route::get('/students/form/{student}', 'form')->name('student.edit');
    Route::post('/students', 'store')->name('student.store');
    Route::put('/students/{student}', 'update')->name('student.update');
    Route::put('/fees', 'updateFees')->name('fee.update');
    Route::delete('/students/{student}', 'destroy')->name('student.destroy');
    Route::post('/students/import','import')->name('student.import');
    Route::get('/students/export','export')->name('student.export');
});

Route::middleware(['auth', 'verified'])->controller(PaymentController::class)->group(function () {
    Route::post('/payment/{student}', 'store')->name('payment.store');
    Route::get('/payment/export','export')->name('payment.export');
    Route::delete('/payment/{payment}','destroy')->name('payment.destroy');
});

Route::middleware(['auth', 'verified'])->controller(AttachmentController::class)->group(function () {
    Route::post('/attachment/{student}', 'store')->name('attachment.store');
    Route::delete('/attachment/{attachment}', 'destroy')->name('attachment.destroy');
});
Route::post('/language-switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/column-preference', [ProfileController::class, 'saveColumnPreferences'])->name('profile.column-preference');
});

require __DIR__.'/auth.php';
