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

Route::get('/order', [OrderManagementController::class, 'getOrderIndex'])->name('order.index');
Route::get('/order/add', [OrderManagementController::class, 'addOrderView'])->name('order.add');

Route::get('/product', [ProductController::class, 'getProductIndex'])->name('product.index');
Route::get('/product/add-view', [ProductController::class, 'addProductView'])->name('product.add-view');
Route::get('/product/edit-view/{id}', [ProductController::class, 'editProductView'])->name('product.edit-view');
Route::post('/product/add', [ProductController::class, 'addProduct'])->name('product.add');
Route::post('/product/edit', [ProductController::class, 'editProduct'])->name('product.edit');
Route::post('/product/delete', [ProductController::class, 'deleteProduct'])->name('product.delete');
Route::post('/product/active', [ProductController::class, 'productUpdateActive'])->name('product.active');
Route::post('/product-get-table-data', [ProductController::class, 'productGetTableData'])->name('product-get-table-data');

Route::get('/product/category', [ProductCategoryController::class, 'getCategoryIndex'])->name('product-category.index');
Route::post('/product/category/add', [ProductCategoryController::class, 'addCategory'])->name('product-category.add');
Route::post('/product/category/edit', [ProductCategoryController::class, 'editCategory'])->name('product-category.edit');
Route::post('/product/category/delete', [ProductCategoryController::class, 'deleteCategory'])->name('product-category.delete');
Route::post('/product/category/active', [ProductCategoryController::class, 'updateActive'])->name('product-category.active');
Route::post('/product/category/table', [ProductCategoryController::class, 'getProductCategoryTable'])->name('product-category.table');

Route::get('/client', [ClientController::class, 'getClientIndex'])->name('client.index');
Route::post('/client/add', [ClientController::class, 'addClient'])->name('client.add');
Route::post('/client/edit', [ClientController::class, 'editClient'])->name('client.edit');
Route::post('/client/delete', [ClientController::class, 'deleteClient'])->name('client.delete');
Route::post('/client/active', [ClientController::class, 'clientUpdateActive'])->name('client.active');
Route::post('/client/table', [ClientController::class, 'getClientTable'])->name('client.table');

Route::get('/store', [StoreManagementController::class, 'getStoreIndex'])->name('store.index');
Route::post('/store/add', [StoreManagementController::class, 'addStore'])->name('store.add');
Route::post('/store/edit', [StoreManagementController::class, 'editStore'])->name('store.edit');
Route::post('/store/delete', [StoreManagementController::class, 'deleteStore'])->name('store.delete');
Route::post('/store/active', [StoreManagementController::class, 'storeUpdateActive'])->name('store.active');
Route::post('/store/table', [StoreManagementController::class, 'storeGetTableData'])->name('store.table');

Route::get('/sample/elibs', [SampleController::class, 'getElibs'])->name('sample.elibs');
Route::get('/sample/cropperJS', [SampleController::class, 'getCropperView'])->name('sample.cropper');
Route::get('/sample/cropperJSView', [SampleController::class, 'getCropperViewReal'])->name('sample.cropperreal');
Route::post('/sample/cropperJSView-upload', [SampleController::class, 'getCropperUpload'])->name('sample.cropperreal-upload');


Route::get('/sample/MarkAnthony', [SampleController::class, 'getMarkAnthony'])->name('sample-mark-anthony');



Route::get('/json-sample/add', [JsonController::class, 'getJsonData'])->name('get-json-data');
Route::post('/json-sample/create-json-file', [JsonController::class, 'postJsonName'])->name('create-json-file');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
});

