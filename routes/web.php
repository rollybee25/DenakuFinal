<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\StoreManagementController;

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
Route::get('/Denaku', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Denaku/sample-cropper', [App\Http\Controllers\ProductController::class, 'sampleCropper'])->name('sample-cropper');

Route::get('/Denaku/products', [ProductController::class, 'getProductIndex'])->name('product.index');
Route::get('/Denaku/product/add-view', [ProductController::class, 'addProductView'])->name('product.add-view');
Route::get('/Denaku/product/edit-view/{id}', [ProductController::class, 'editProductView'])->name('product.edit-view');
Route::post('/Denaku/product/add', [ProductController::class, 'addProduct'])->name('product.add');
Route::post('/Denaku/product/edit', [ProductController::class, 'editProduct'])->name('product.edit');
Route::post('/Denaku/product/delete', [ProductController::class, 'deleteProduct'])->name('product.delete');
Route::post('/Denaku/product/active', [ProductController::class, 'productUpdateActive'])->name('product.active');
Route::post('/product-get-table-data', [ProductController::class, 'productGetTableData'])->name('product-get-table-data');


Route::get('/Denaku/product/category', [ProductCategoryController::class, 'getCategoryIndex'])->name('product-category.index');
Route::post('/Denaku/product/category/add', [ProductCategoryController::class, 'addCategory'])->name('product-category.add');
Route::post('/Denaku/product/category/edit', [ProductCategoryController::class, 'editCategory'])->name('product-category.edit');
Route::post('/Denaku/product/category/delete', [ProductCategoryController::class, 'deleteCategory'])->name('product-category.delete');
Route::post('/Denaku/product/category/active', [ProductCategoryController::class, 'updateActive'])->name('product-category.active');
Route::post('/Denaku/product/category/table', [ProductCategoryController::class, 'getProductCategoryTable'])->name('product-category.table');


Route::get('/Denaku/store', [StoreManagementController::class, 'getStoreIndex'])->name('store.index');
Route::post('/Denaku/store/table', [StoreManagementController::class, 'storeGetTableData'])->name('store.table');

Route::get('/Denaku/sample/cropperJS', [SampleController::class, 'getCropperView'])->name('sample.cropper');
Route::get('/Denaku/sample/cropperJSView', [SampleController::class, 'getCropperViewReal'])->name('sample.cropperreal');
Route::post('/Denaku/sample/cropperJSView-upload', [SampleController::class, 'getCropperUpload'])->name('sample.cropperreal-upload');


Route::get('/Denaku/sample/MarkAnthony', [SampleController::class, 'getMarkAnthony'])->name('sample-mark-anthony');



Route::get('/Denaku/json-sample/add', [JsonController::class, 'getJsonData'])->name('get-json-data');
Route::post('/Denaku/json-sample/create-json-file', [JsonController::class, 'postJsonName'])->name('create-json-file');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
});

