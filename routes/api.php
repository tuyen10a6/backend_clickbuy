<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\WareHouseController;
use App\Http\Controllers\Api\WareHouseDetailsController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\ImportInvoiceController;
use App\Http\Controllers\Api\ImportInvoiceDetailController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SlideHomeController;
use App\Http\Controllers\Api\ImageSaleRightHomeController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\EventMarketingController;
use App\Http\Controllers\Api\EventMarketingDetailController;


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
Route::get('product/getProductNew', [ProductController::class, 'getProductSale']);
Route::get('variant/variantByProduct', [ProductVariantController::class, 'getVariantByProduct']);
Route::get('variant/variantByID', [ProductVariantController::class, 'getVariantByID']);
Route::get('variant/all', [ProductVariantController::class, 'getAllVariant']);
Route::get('warehouse/getAllWareHouse', [WareHouseController::class, 'getAllWareHouse']);
Route::get('warehouse/getWareHouseByID', [WareHouseController::class, 'getWareHouseByID']);
Route::get('warehouseDetails/allWareHouseDetailByID', [WareHouseDetailsController::class, 'getAllWareHouseDetailsByID']);
Route::get('warehouseDetails/getAll', [WareHouseDetailsController::class, 'getAllWareHouse']);
Route::get('/warehouseDetail/getWareHouseDetailByID', [WareHouseDetailsController::class, 'getWareHouseDetailByID']);
Route::get('getCategoryByID', [CategoryController::class, 'getCategoryByID']);
Route::get('/supplier/getAll', [SupplierController::class, 'getAllSupplier']);
Route::get('/supplier/getSupplierByID', [SupplierController::class, 'getSupplierByID']);
Route::get('/importInvoice/getAllImportInvoice', [ImportInvoiceController::class, 'getAllImportInvoice']);
Route::get('/importInvoice/getDetails', [ImportInvoiceController::class, 'getImportInvoiceDetails']);
Route::post('order/store', [OrderController::class, 'store']);
Route::get('order/getAll', [OrderController::class, 'getAll']);
Route::get('slide/getAll', [SlideHomeController::class, 'getAll']);
Route::get('slide/getDetail', [SlideHomeController::class, 'getDetailSlide']);
Route::get('imageRightHome/getAll', [ImageSaleRightHomeController::class, 'getAll']);
Route::get('imageRightHome/getDetail', [ImageSaleRightHomeController::class, 'getDetail']);
Route::get('product/search', [ProductController::class, 'searchProduct']);
Route::get('customer/getAll', [CustomerController::class, 'getAll']);
Route::get('customer/search', [CustomerController::class, 'searchProduct']);
Route::get('order/detail', [OrderController::class, 'getDetail']);
Route::get('order/status', [OrderController::class, 'getOrderStatus']);
Route::get('order/count', [OrderController::class, 'countOrder']);
Route::get('order/totalPrice', [OrderController::class, 'totalRevenue']);
Route::get('order/totalPriceDate', [OrderController::class, 'totalRevenueNowDate']);
Route::get('order/totalReview', [OrderController::class, 'totalReview']);
Route::get('order/getProductTopBuy', [OrderController::class, 'getProductTopBuy']);
Route::get('order/totalOrderStatus', [OrderController::class, 'totalOrderStatus']);
Route::get('order/historyOrder', [OrderController::class, 'searchOrderHistory']);
Route::get('review/getAll', [ReviewController::class, 'getAll']);
Route::get('review/getReviewByProduct', [ReviewController::class, 'getCommentByProduct']);
Route::post('review/addReview', [ReviewController::class, 'addComment']);
Route::get('review/searchProduct', [ReviewController::class, 'searchByProductName']);
Route::get('eventMarketing/getAll', [EventMarketingController::class, 'getEventMarketing']);
Route::get('eventMarketing/detail', [EventMarketingController::class, 'getDetail']);
Route::get('eventMarketingDetail/detail', [EventMarketingDetailController::class, 'getDetail']);
Route::get('eventMarketingDetail/getAll', [EventMarketingDetailController::class, 'getEventMarketingDetail']);
Route::get('categories/searchProduct', [ProductController::class, 'searchProductByCategories']);
Route::get('product/searchPrice', [ProductController::class, 'searchPrice']);
Route::get('order/orderByStatus', [OrderController::class, 'getOrderByStatus']);
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
        Route::post('update', [WareHouseDetailsController::class, 'updateWareHouseDetails']);
    });

    Route::prefix('supplier')->group(function () {
        Route::post('store', [SupplierController::class, 'store']);
        Route::post('update', [SupplierController::class, 'update']);
    });

    Route::prefix('importInvoice')->group(function () {
        Route::post('store', [ImportInvoiceController::class, 'store']);
        Route::post('update', [ImportInvoiceController::class, 'update']);
    });

    Route::prefix('importInvoiceDetail')->group(function () {
        Route::post('store', [ImportInvoiceDetailController::class, 'store']);
//        Route::post('update', [ImportInvoiceDetailController::class, 'update']);
    });

    Route::prefix('slide')->group(function () {
        Route::post('store', [SlideHomeController::class, 'store']);
        Route::post('update', [SlideHomeController::class, 'update']);
    });

    Route::prefix('imageSaleRightHome')->group(function () {
        Route::post('store', [ImageSaleRightHomeController::class, 'store']);
        Route::post('update', [ImageSaleRightHomeController::class, 'update']);
    });

    Route::prefix('order')->group(function () {
        Route::post('update', [OrderController::class, 'update']);
    });
    Route::prefix('review')->group(function () {
        Route::post('update', [ReviewController::class, 'update']);
    });
    Route::prefix('eventMarketing')->group(function () {
        Route::post('store', [EventMarketingController::class, 'store']);
        Route::post('update', [EventMarketingController::class, 'update']);
    });

    Route::prefix('eventMarketingDetail')->group(function () {
           Route::post('store', [EventMarketingDetailController::class, 'store']);
           Route::post('update', [EventMarketingDetailController::class, 'update']);
    });
});
