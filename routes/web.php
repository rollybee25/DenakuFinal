<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\StoreManagementController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\PointOfSaleController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SalesController;



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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/sample-cropper', [App\Http\Controllers\ProductController::class, 'sampleCropper'])->name('sample-cropper');

Route::prefix('/sales')->group(function () {
    Route::get('/', [SalesController::class, 'getSalesView'])->name('sales.view');
});

Route::prefix('/pos')->group(function () {
    Route::get('/', [PointOfSaleController::class, 'getPOSView'])->name('pos.view');
    Route::post('/add', [PointOfSaleController::class, 'addSale'])->name('pos.add');
});

Route::prefix('/order')->group(function () {
    Route::get('/', [OrderManagementController::class, 'getOrderIndex'])->name('order.index');
    Route::get('/add', [OrderManagementController::class, 'addOrderView'])->name('order.add');
    Route::post('/category-select', [OrderManagementController::class, 'getCategorySelect'])->name('order.category.select');
    Route::post('/get-one-product', [OrderManagementController::class, 'getOneProduct'])->name('order.product.details');
    Route::get('/get-category-load', [OrderManagementController::class, 'getCategoryLoad'])->name('order.category.load');
});

Route::prefix('/product')->group(function () {
    Route::get('/', [ProductController::class, 'getProductIndex'])->name('product.index');
    Route::get('/add-view', [ProductController::class, 'addProductView'])->name('product.add-view');
    Route::get('/edit-view/{id}', [ProductController::class, 'editProductView'])->name('product.edit-view');
    Route::post('/add', [ProductController::class, 'addProduct'])->name('product.add');
    Route::post('/add-stocks', [ProductController::class, 'addProductStocks'])->name('product.add-stocks');
    Route::post('/edit', [ProductController::class, 'editProduct'])->name('product.edit');
    Route::post('/delete', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::post('/active', [ProductController::class, 'productUpdateActive'])->name('product.active');
    Route::post('/product-get-table-data', [ProductController::class, 'productGetTableData'])->name('product-get-table-data');
});

Route::prefix('/product/category')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'getCategoryIndex'])->name('product-category.index');
    Route::post('/add', [ProductCategoryController::class, 'addCategory'])->name('product-category.add');
    Route::post('/edit', [ProductCategoryController::class, 'editCategory'])->name('product-category.edit');
    Route::post('/delete', [ProductCategoryController::class, 'deleteCategory'])->name('product-category.delete');
    Route::post('/active', [ProductCategoryController::class, 'updateActive'])->name('product-category.active');
    Route::post('/table', [ProductCategoryController::class, 'getProductCategoryTable'])->name('product-category.table');
});

Route::prefix('/client')->group(function () {
    Route::get('/', [ClientController::class, 'getClientIndex'])->name('client.index');
    Route::post('/add', [ClientController::class, 'addClient'])->name('client.add');
    Route::post('/edit', [ClientController::class, 'editClient'])->name('client.edit');
    Route::post('/delete', [ClientController::class, 'deleteClient'])->name('client.delete');
    Route::post('/active', [ClientController::class, 'clientUpdateActive'])->name('client.active');
    Route::post('/table', [ClientController::class, 'getClientTable'])->name('client.table');
});

Route::prefix('/store')->group(function () {
    Route::get('/', [StoreManagementController::class, 'getStoreIndex'])->name('store.index');
    Route::post('/add', [StoreManagementController::class, 'addStore'])->name('store.add');
    Route::post('/edit', [StoreManagementController::class, 'editStore'])->name('store.edit');
    Route::post('/delete', [StoreManagementController::class, 'deleteStore'])->name('store.delete');
    Route::post('/active', [StoreManagementController::class, 'storeUpdateActive'])->name('store.active');
    Route::post('/table', [StoreManagementController::class, 'storeGetTableData'])->name('store.table');
});


Route::get('/sample/elibs', [SampleController::class, 'getElibs'])->name('sample.elibs');
Route::get('/sample/cropperJS', [SampleController::class, 'getCropperView'])->name('sample.cropper');
Route::get('/sample/cropperJSView', [SampleController::class, 'getCropperViewReal'])->name('sample.cropperreal');
Route::post('/sample/cropperJSView-upload', [SampleController::class, 'getCropperUpload'])->name('sample.cropperreal-upload');


Route::get('/sample/MarkAnthony', [SampleController::class, 'getMarkAnthony'])->name('sample-mark-anthony');


Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('pdf.test');;


Route::get('/json-sample/add', [JsonController::class, 'getJsonData'])->name('get-json-data');
Route::post('/json-sample/create-json-file', [JsonController::class, 'postJsonName'])->name('create-json-file');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
});

