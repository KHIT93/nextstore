<?php

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
    return view('welcome');
})->name('home');

Auth::routes();

Route::prefix('backend')->group(function(){
    Route::get('/', 'BackendController@index')->name('backend.home');
});

Route::prefix('webapi')->group(function(){
    Route::get('/products', 'ProductsController@index')->name('webapi.products.index');
    Route::put('/products', 'ProductsController@store')->name('webapi.products.create');
    Route::get('/products/{product}', 'ProductsController@show')->name('webapi.products.show');
    Route::patch('/products/{product}', 'ProductsController@update')->name('webapi.products.update');
    Route::delete('/products/{product}', 'ProductsController@destroy')->name('webapi.products.destroy');

    Route::get('/categories', 'CategoriesController@index')->name('webapi.categories.index');
    Route::put('/categories', 'CategoriesController@store')->name('webapi.categories.create');
    Route::get('/categories/{category}', 'CategoriesController@show')->name('webapi.categories.show');
    Route::patch('/categories/{category}', 'CategoriesController@update')->name('webapi.categories.update');
    Route::delete('/categories/{category}', 'CategoriesController@destroy')->name('webapi.categories.destroy');
});
