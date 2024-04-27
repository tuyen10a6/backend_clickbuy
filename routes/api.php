<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

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

Route::get('/', function () {
    return response()->json([
        'status' => true,
        'message' => 'Hello World'
    ]);
});

Route::get('category/getAll', [CategoryController::class, 'getCategory']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->middleware(['cors']);;
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['cors']);;
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware(['cors']);;
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware(['admin.auth', 'cors'])->group(function () {
    Route::prefix('category')->group(function () {
        Route::post('/store', [CategoryController::class, 'store']);
        Route::post('/update', [CategoryController::class, 'update']);
        Route::delete('/delete/{id}', [CategoryController::class, 'delete']);
    });
});
