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

Route::group(['prefix' => 'auth'], function () {
	Route::get('install', 'AppsController@installApp')->name('apps.installApp');
    Route::post('installHandle', 'AppsController@installAppHandle')->name('apps.installHandle');
    Route::get('auth', 'AppsController@auth')->name('apps.auth');
    Route::get('404', 'AppsController@errors')->name('errors.404');
    Route::get('logout','AppsController@logout')->name('apps.logout');
});


//WebHook middleware
Route::group(['middleware' => ['webhook.verify'], 'prefix' => 'webhook'], function() {
	Route::post('app_uninstalled', 'WebHookController@uninstallApp')->name('webhook.uninstall_app');
    Route::post('shop_update', 'WebHookController@shopUpdate')->name('webhook.shop_update');
	Route::post('orders_paid', 'WebHookController@ordersUpdated')->name('webhook.orders_paid');
	Route::post('orders_updated', 'WebHookController@ordersUpdated')->name('webhook.orders_updated');
	Route::post('created_product', 'WebHookController@createdProduct')->name('webhook.create_product');
	Route::post('updated_product', 'WebHookController@updatedProduct')->name('webhook.update_product');
	// Route::post('delete_product', 'WebHookController@deleteProduct')->name('webhook.delete_product');
	// Route::post('update_fulfillments', 'WebHookController@updateFulfillments')->name('webhook.update_fulfillments');
    // Route::post('create_fulfillments', 'WebHookController@createFulfillments')->name('webhook.create_fulfillments');
    // Route::post('customers_redact', 'WebHookController@customersRedact')->name('webhook.customers_redact');
    // Route::post('shop_redact', 'WebHookController@shopRedact')->name('webhook.shop_redact');
    // Route::get('refunds_create', 'WebHookController@refundsCreate')->name('webhook.refunds_create');
    // Route::get('orders_fulfilled', 'WebHookController@ordersFulfilled')->name('webhook.orders_fulfilled');
    // Route::get('orders_partially_fulfilled', 'WebHookController@ordersPartiallyFulfilled')->name('webhook.orders_partially_fulfilled');
});

//Route  ThemeSetting
Route::group(['middleware' => [] ], function() {
	Route::get('/','DashboardController@index')->name('dashboard');
});

//Route  Slider
Route::group(['middleware' => [],'prefix'=>'slider'], function() {
	Route::get('/', 'SliderController@index')->name('slider');
});


//Route  ThemeSetting
Route::group(['middleware' => [],'prefix'=>'setting'], function() {
	Route::get('/', 'ThemeSettingController@index')->name('setting');
});

//Route  Products
Route::group(['middleware' => [],'prefix'=>'products'], function() {
	Route::get('/', 'ProductsController@index')->name('products');
});


// Route::get('/', function () {
//     return view('welcome');
// });
