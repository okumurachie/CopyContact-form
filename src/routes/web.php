<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;

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


Route::get('/', [ContactController::class, 'index'])->name('contact.form');
Route::get('/confirm', [ContactController::class, 'showConfirmForm']);
Route::post('/confirm', [ContactController::class, 'confirm'])->name('confirm');
Route::post('/send', [ContactController::class, 'send'])->name('send');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('thanks');


Route::middleware('auth')->group(function () {
    Route::get('/admin', [UserController::class, 'showAdminForm'])->name('admin');
    Route::get('/admin/search', [UserController::class, 'search'])->name('search');
    Route::post('/admin/delete/{id}', [ContactController::class, 'softDelete'])->name('contact.softDelete');
});
