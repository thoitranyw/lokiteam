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

Route::group(['middleware' => ['cors'],'prefix' => 'auth' ], function () {
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
});

Route::group(['middleware' => [], 'prefix' => 'theme'], function() {
	Route::get('/{shopId}','SliderController@getSliderTheme')->name('admin-api.sliders.getSliderTheme');
	Route::post('/{shopId}/view','ProductController@incrementView')->name('admin-api.sliders.incrementView');
	Route::post('/{shopId}/add_to_cart','ProductController@incrementAddToCart')->name('admin-api.sliders.incrementAddToCart');
});

Route::get('SyncProduct/{shopId}','AppsController@SyncProduct')->name('admin-api.sliders.SyncProduct');

// 
Route::group(['middleware' => ['shopify.check'], 'prefix' => 'admin-api'], function () {
	Route::group(['middleware' => [], 'prefix' => 'products'], function () {
		Route::get('/funnel','ProductController@funnel')->name('admin-api.products.funnel');
		Route::get('/','ProductController@getProduct')->name('admin-api.products.getProduct');
	});
	Route::group(['middleware' => [], 'prefix' => 'sliders'], function () {
		Route::get('/','SliderController@getSliderAdmin')->name('admin-api.sliders.getSliderAdmin');
		Route::post('/set_position','SliderController@setProductPosition')->name('admin-api.sliders.setProductPosition');
		Route::post('/unset_position','SliderController@unsetPosition')->name('admin-api.sliders.unsetPosition');
	});
});

//Route  ThemeSetting
Route::group(['middleware' => ['shopify.check'] ], function() {
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
