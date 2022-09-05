<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanViewController;
use App\Http\Controllers\BookViewController;
use App\Http\Controllers\UserViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/users', [UserViewController::class, 'index'])->middleware(['auth'])->name('users');

Route::get('/books', [BookViewController::class, 'index'])->middleware(['auth'])->name('books');

Route::get('/loans', [LoanViewController::class, 'index'])->middleware(['auth'])->name('loans');

require __DIR__.'/auth.php';
