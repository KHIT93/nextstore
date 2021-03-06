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

        Route::get('/taxes', 'Backend\TaxesController@index')->name('webapi.taxes.index');
        Route::put('/taxes', 'Backend\TaxesController@store')->name('webapi.taxes.create');
        Route::get('/taxes/{tax}', 'Backend\TaxesController@show')->name('webapi.taxes.show');
        Route::patch('/taxes/{tax}', 'Backend\TaxesController@update')->name('webapi.taxes.update');
        Route::delete('/taxes/{tax}', 'Backend\TaxesController@destroy')->name('webapi.taxes.destroy');

        Route::delete('/images/{image}', 'ImagesController@destroy');
    });
});

Route::get('/shop', 'CategoriesController@index')->name('shop');
Route::get('/categories/{category}', 'CategoriesController@show')->name('category.show');
Route::get('/products/{product}', 'ProductsController@show')->name('products.show');

Route::get('/cart', 'CartController@show')->name('cart.show');
Route::post('/cart','CartController@store')->name('cart.store');
Route::patch('/cart','CartController@updateItem')->name('cart.item.update');
Route::delete('/cart','CartController@deleteItem')->name('cart.item.delete');

Route::get('/checkout', 'CheckoutController@signin')->name('checkout.signin');
Route::post('/checkout/register', 'CheckoutController@register')->name('checkout.register');
Route::get('/checkout/address/billing', 'CheckoutController@billingAddress')->name('checkout.address.billing');
Route::post('/checkout/address/billing', 'CheckoutController@billingAddressPostback')->name('checkout.billing.post');
Route::get('/checkout/address/shipping', 'CheckoutController@shippingAddress')->name('checkout.address.shipping');
Route::post('/checkout/address/shipping', 'CheckoutController@shippingAddressPostback')->name('checkout.shipping.post');
Route::get('/checkout/address/create', 'CheckoutController@createAddress')->name('checkout.address.create');
Route::post('/checkout/address/create', 'CheckoutController@storeAddress')->name('checkout.address.store');
