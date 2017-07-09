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
    return view('home');
})->name('home');

Route::get('images/{image}', 'ImagesController@show');

Auth::routes();

Route::prefix('backend')->group(function(){
    Route::get('/', 'Backend\BackendController@index')->name('backend.home')->middleware('auth');
    Route::get('/login', 'Auth\LoginController@showBackendLoginForm')->name('backend.auth.login');
});

Route::prefix('webapi')->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('/products', 'Backend\ProductsController@index')->name('webapi.products.index');
        Route::put('/products', 'Backend\ProductsController@store')->name('webapi.products.create');
        Route::get('/products/{product}', 'Backend\ProductsController@show')->name('webapi.products.show');
        Route::patch('/products/{product}', 'Backend\ProductsController@update')->name('webapi.products.update');
        Route::delete('/products/{product}', 'Backend\ProductsController@destroy')->name('webapi.products.destroy');

        Route::get('/products/{product}/images', 'Backend\ProductImagesController@show');
        Route::post('/products/{product}/images', 'Backend\ProductImagesController@store');

        Route::get('/categories', 'Backend\CategoriesController@index')->name('webapi.categories.index');
        Route::put('/categories', 'Backend\CategoriesController@store')->name('webapi.categories.create');
        Route::get('/categories/{category}', 'Backend\CategoriesController@show')->name('webapi.categories.show');
        Route::patch('/categories/{category}', 'Backend\CategoriesController@update')->name('webapi.categories.update');
        Route::delete('/categories/{category}', 'Backend\CategoriesController@destroy')->name('webapi.categories.destroy');

        Route::get('/pages', 'Backend\PagesController@index')->name('webapi.pages.index');
        Route::put('/pages', 'Backend\PagesController@store')->name('webapi.pages.create');
        Route::get('/pages/{page}', 'Backend\PagesController@show')->name('webapi.pages.show');
        Route::patch('/pages/{page}', 'Backend\PagesController@update')->name('webapi.pages.update');
        Route::delete('/pages/{page}', 'Backend\PagesController@destroy')->name('webapi.pages.destroy');

        Route::delete('/images/{image}', 'ImagesController@destroy');
    });
});
