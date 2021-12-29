<?php

use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('profile', [UserController::class, 'profile']);

    Route::get('get-messages', [ChatController::class, 'getMessages']);
    Route::post('send-message', [ChatController::class, 'sendMessage']);
});

Route::post('login', [UserController::class, 'login']);

