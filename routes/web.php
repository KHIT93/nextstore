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

Route::get('images/{image}', 'ImagesController@show');

Auth::routes();

Route::prefix('backend')->group(function(){
    Route::get('/', 'BackendController@index')->name('backend.home')->middleware('auth');
    Route::get('/login', 'Auth\LoginController@showBackendLoginForm')->name('backend.auth.login');
});

Route::prefix('webapi')->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('/products', 'ProductsController@index')->name('webapi.products.index');
        Route::put('/products', 'ProductsController@store')->name('webapi.products.create');
        Route::get('/products/{product}', 'ProductsController@show')->name('webapi.products.show');
        Route::patch('/products/{product}', 'ProductsController@update')->name('webapi.products.update');
        Route::delete('/products/{product}', 'ProductsController@destroy')->name('webapi.products.destroy');

        Route::get('/products/{product}/images', 'ProductImagesController@show');
        Route::post('/products/{product}/images', 'ProductImagesController@store');

        Route::get('/categories', 'CategoriesController@index')->name('webapi.categories.index');
        Route::put('/categories', 'CategoriesController@store')->name('webapi.categories.create');
        Route::get('/categories/{category}', 'CategoriesController@show')->name('webapi.categories.show');
        Route::patch('/categories/{category}', 'CategoriesController@update')->name('webapi.categories.update');
        Route::delete('/categories/{category}', 'CategoriesController@destroy')->name('webapi.categories.destroy');

        Route::get('/pages', 'PagesController@index')->name('webapi.pages.index');
        Route::put('/pages', 'PagesController@store')->name('webapi.pages.create');
        Route::get('/pages/{page}', 'PagesController@show')->name('webapi.pages.show');
        Route::patch('/pages/{page}', 'PagesController@update')->name('webapi.pages.update');
        Route::delete('/pages/{page}', 'PagesController@destroy')->name('webapi.pages.destroy');

        Route::delete('/images/{image}', 'ImagesController@destroy');
    });
});
