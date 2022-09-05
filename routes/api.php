<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index'])->name('user.get.all');
Route::get('/users/{id}', [UserController::class, 'show'])->name('user.get.one');
Route::post('/users', [UserController::class, 'store'])->name('user.create');
Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');

Route::get('/books', [BookController::class, 'index'])->name('book.get.all');
Route::get('/books/{id}', [BookController::class, 'show'])->name('book.get');
Route::post('/books', [BookController::class, 'store'])->name('book.create');
Route::put('/books/{id}', [BookController::class, 'update'])->name('book.update');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('book.delete');

Route::get('/loans', [LoanController::class, 'index'])->name('loan.get.all');
Route::get('/loans/{id}', [LoanController::class, 'show'])->name('loan.get');
Route::post('/loans', [LoanController::class, 'store'])->name('loan.create');
Route::put('/loans/{id}', [LoanController::class, 'update'])->name('loan.update');
Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loan.delete');

Route::put('/loans/{id}/peminjaman-status', [LoanController::class, 'updateStatusPeminjaman'])->name('loan.updateSP');
Route::put('/loans/{id}/kesiapan-pinjam', [LoanController::class, 'updateKesiapanPinjam'])->name('loan.updateKP');

