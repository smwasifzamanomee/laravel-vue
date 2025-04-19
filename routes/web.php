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

Route::get('/', function () {
    return view('home.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/category', 'Admin\Category\CategoryController@index');
Route::post('/category/store', 'Admin\Category\CategoryController@store')->name('category.store');
Route::get('/category/delete/{id}', 'Admin\Category\CategoryController@destroy')->name('category.delete');
Route::get('/category/edit/{id}', 'Admin\Category\CategoryController@edit')->name('category.edit');
Route::post('/category/update', 'Admin\Category\CategoryController@update')->name('category.update');
