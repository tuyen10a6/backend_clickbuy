<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\WareHouseController;
use App\Http\Controllers\Api\WareHouseDetailsController;

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
Route::get('brand/getBrandByID', [BrandController::class, 'getBrandByID']);
Route::get('product/getAll', [ProductController::class, 'getAllProduct']);
Route::get('product/getProductByID', [ProductController::class, 'getProductByID']);
Route::get('product/getProductByCategory', [ProductController::class, 'getProductByCategory']);
Route::get('variant/variantByProduct', [ProductVariantController::class, 'getVariantByProduct']);
Route::get('variant/variantByID', [ProductVariantController::class, 'getVariantByID']);
Route::get('variant/all', [ProductVariantController::class, 'getAllVariant']);
Route::get('warehouse/getAllWareHouse', [WareHouseController::class, 'getAllWareHouse']);
Route::get('warehouse/getWareHouseByID', [WareHouseController::class, 'getWareHouseByID']);
Route::get('warehouseDetails/allWareHouseDetailByID', [WareHouseDetailsController::class, 'getAllWareHouseDetailsByID']);
Route::get('warehouseDetails/getAll', [WareHouseDetailsController::class, 'getAllWareHouse']);
Route::get('getCategoryByID', [CategoryController::class, 'getCategoryByID']);
Route::post('/uploads', [\App\Http\Controllers\Api\UploadController::class, 'upload'])->middleware(['cors']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->middleware(['cors']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['cors']);
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware(['cors']);
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
    Route::prefix('variant')->group(function () {
        Route::post('/store', [ProductVariantController::class, 'store']);
        Route::post('/update', [ProductVariantController::class, 'update']);
        Route::delete('/delete', [ProductVariantController::class, 'delete']);
    });

    Route::prefix('warehouse')->group(function () {
        Route::post('/store', [WareHouseController::class, 'addWareHouse']);
        Route::post('/update', [WareHouseController::class, 'updateWareHouse']);
        Route::delete('/delete', [WareHouseController::class, 'deleteWareHouse']);
    });

    Route::prefix('wareHouseDetails')->group(function () {
        Route::post('store', [WareHouseDetailsController::class, 'store']);
    });

});
