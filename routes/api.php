<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;

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
Route::get('brand/getAll', [BrandController::class, 'getAllBrand']);
Route::get('product/getAll', [ProductController::class, 'getAllProduct']);

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
    Route::prefix('brand')->group(function () {
        Route::post('/store', [BrandController::class, 'store']);
        Route::post('/update', [BrandController::class, 'update']);
        Route::delete('/delete', [BrandController::class, 'delete']);
    });
    Route::prefix('product')->group(function () {
        Route::post('/store', [ProductController::class, 'store']);
        Route::post('/update', [ProductController::class, 'update']);
        Route::delete('/delete', [ProductController::class, 'delete']);
    });
});
