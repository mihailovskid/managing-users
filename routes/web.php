<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('', [UserController::class, 'index'])->middleware('auth', 'check.role')->name('index');

Route::get('/admin/create', [AdminController::class, 'create'])->middleware('auth', 'check.admin')->name('admin.create');
Route::get('/admin/dashboard', [AdminController::class, 'showIndexPage'])->middleware('auth', 'check.admin')->name('admin.dashboard');
Route::get('/admin/edit', [AdminController::class, 'edit'])->middleware('auth', 'check.admin')->name('admin.edit');
Route::get('/activate/{email}/{code}', [UserController::class, 'activate'])->name('activate');
