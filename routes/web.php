<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\PagesController;

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


Route::get('/', [\App\Http\Controllers\PagesController::class, 'index'])->name('welcome');

Route::get('/about', [App\Http\Controllers\PagesController::class, 'about'])->name('about');

Route::get('/contact', [App\Http\Controllers\PagesController::class, 'contact'])->name('contact');

Route::get('/privacypolicy', [App\Http\Controllers\PagesController::class, 'privacypolicy'])->name('privacypolicy');

Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::get('/dashboard', [App\Http\Controllers\PagesController::class, 'dashboard'])->name('dashboard');

require __DIR__.'/auth.php';
