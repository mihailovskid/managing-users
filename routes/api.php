<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AdminController as ApiAdminController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('get-users', [AdminController::class, 'index']);
Route::get('get-user', [AdminController::class, 'show']);
Route::put('update-user', [ApiAdminController::class, 'update']);
Route::delete('delete-user', [ApiAdminController::class, 'destroy']);
Route::post('create-user', [ApiAdminController::class, 'store']);
Route::put('user-status', [ApiAdminController::class, 'statusActivate']);
