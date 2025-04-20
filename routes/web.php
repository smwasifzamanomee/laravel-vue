<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', 'Home\Product\ProductController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/category', 'Admin\Category\CategoryController@index');
Route::post('/category/store', 'Admin\Category\CategoryController@store')->name('category.store');
Route::get('/category/delete/{id}', 'Admin\Category\CategoryController@destroy')->name('category.delete');
Route::get('/category/edit/{id}', 'Admin\Category\CategoryController@edit')->name('category.edit');
Route::post('/category/update', 'Admin\Category\CategoryController@update')->name('category.update');

Route::get('/products', 'Admin\Product\ProductController@index');
Route::get('/products/create', 'Admin\Product\ProductController@create')->name('products.create');
Route::post('/products/store', 'Admin\Product\ProductController@store')->name('products.store');
Route::get('/products/edit/{id}', 'Admin\Product\ProductController@edit')->name('products.edit');
Route::post('/products/update/{id}', 'Admin\Product\ProductController@update')->name('products.update');
Route::get('/products/delete/{id}', 'Admin\Product\ProductController@destroy')->name('products.delete');

// Route::resources('product', 'Admin\Product\ProductController');