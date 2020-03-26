<?php 

Route::group(['namespace' => 'App\Modules\Cart\Http\Controllers', 'middleware' => ['web']], function () {

	// Cart
	Route::get('catalog', 'ProductController@index');
	Route::get('catalog/{product}', 'ProductController@show');
	Route::get('cart/add/{id}', 'CartController@addToCart');
	Route::post('cart/add', 'CartController@addToCartbyForm');
	Route::get('cart/remove/{id}', 'CartController@removeFromCart');
	Route::get('cart/clear', 'CartController@clearCart');
	Route::get('checkout', 'CartController@showCheckout')->name('cart.checkout');
	Route::post('order', 'OrderController@store');
	Route::get('thank-you', 'OrderController@showThankyou')->name('cart.thankyou');

});

Route::group(['namespace'=>'App\Modules\Cart\Http\Controllers\Admin', 'middleware' => ['web', 'auth'], 'prefix' => 'admin'], function () {

	Route::resource('store/orders', 'OrderController');
	Route::post('store/orders/{id}/shipping', 'OrderController@updateShipping');
	Route::resource('store/products', 'ProductController', ['as'=>'admin']);

});