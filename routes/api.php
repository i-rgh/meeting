<?php

use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login',   [LoginController::class, 'login'])->middleware(['json.response', 'cors' , 'throttle:5,1'])->name('auth.login');
Route::post('auth/logout',  [LoginController::class, 'logout'])->middleware(['auth:api', 'json.response', 'cors'])->name('auth.logout');

Route::get('users',          [UserController::class, 'index'])->name('users.index')->middleware('auth:api', 'cors');

Route::prefix('room')->name('room.')->middleware('cors', 'auth:api')->group(function () {
    Route::get('myRooms',           [RoomController::class, 'show'])->name('show');
    Route::post('create',           [RoomController::class, 'create'])->name('create');
    Route::post('join',             [RoomController::class, 'join'])->name('join');
});
