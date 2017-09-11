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
});

Route::get('/register/confirm-sms', 'Auth\RegisterController@showConfirmSmsForm');
Route::post('/register/confirm-sms', 'Auth\RegisterController@confirmSms');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'CabinetController@index');
    Route::resource('transports','TransportController');
    Route::resource('orders','OrderController');
    Route::get('orders/{id}/cancel-a-driver', 'OrderController@cancelADriver');
    Route::get('orders/{id}/confirm-a-driver-request/{request_id}', 'OrderController@confirmADriverRequest');

    Route::post('ajax/new-order', 'AjaxController@newOrder');
    Route::get('ajax/list-auto-models','AjaxController@listAutoModels');
    Route::get('ajax/list-auto-brands','AjaxController@listAutoBrands');
    Route::get('ajax/list-drivers','AjaxController@listDrivers');
    Route::get('ajax/list-all-drivers', 'AjaxController@listAllDrivers');

    Route::get('ajax/change-role','AjaxController@changeRole');
    Route::delete('ajax/destroy-document/{id}', 'AjaxController@destroyDocument');
    Route::delete('ajax/destroy-transport-image/{id}', 'AjaxController@destroyTransportImage');


    Route::get('profile','UserController@profile');
    Route::post('user/change-password', 'UserController@changePassword');
    Route::get('user/remove-avatar', 'UserController@removeAvatar');
    Route::post('user/update','UserController@update');
    Route::resource('favourites','UserFavouriteCarController');
    Route::get('privacy', 'CabinetController@privacy');

    Route::group(['middleware' => 'role:admin'], function(){
        Route::resource('projects','ProjectController', ['except' => 'show']);
        Route::resource('admin/users','AdminUserController');
        Route::resource('projects.accounts', 'ProjectAccountController', ['parameters' => 'singular']);
        Route::resource('projects.services', 'ProjectServicesController', ['parameters' => 'singular']);
    });

    Route::group(['middleware' => 'role:operator'], function(){

        Route::post('projects/{id}/print-orders', 'ProjectController@printOrders');
        Route::post('projects/{id}/print-registries','ProjectController@printRegistries');
        Route::get('projects/{id}/create-order', 'ProjectController@createOrder');
        Route::resource('projects.orders', 'ProjectOrderController', ['parameters' => 'singular']);
        Route::get('projects/{id}', 'ProjectController@show');
        Route::resource('projects.registries', 'ProjectRegistryController', ['parameters' => 'singular']);
        Route::post('projects/{id}/registries/{registry_id}/complete','ProjectRegistryController@complete');
        Route::get('projects/{id}/orders/{order_id}/driver-requests','ProjectOrderController@driverRequests');
        Route::get('projects/{id}/orders/{order_id}/cancel','ProjectOrderController@cancel');
        Route::get('projects/{id}/orders/{order_id}/print','ProjectOrderController@printOrder');
        Route::get('projects/{id}/orders/{order_id}/print','ProjectOrderController@printOrder');
        Route::post('projects/{id}/orders/{order_id}/comment','ProjectOrderController@comment');
        Route::resource('projects.contractors', 'ProjectContractorController', ['parameters' => 'singular']);

        Route::resource('projects.contractors.legal-supports', 'ProjectLegalSupportController', ['parameters' => 'singular']);
    });

    Route::group(['prefix' => 'driver', 'middleware'=> 'role:driver'], function(){
        Route::post('orders/pick-up-the-order', 'DriverOrdersController@pickUpTheOrder');
        Route::get('orders/{id}/cancel-request/{request_id}', 'DriverOrdersController@cancelRequest');
        Route::resource('orders','DriverOrdersController');
        Route::get('transports/choose-category', 'DriverTransportsController@chooseCategory');
        Route::resource('transports','DriverTransportsController');
        Route::resource('special-offers','DriverSpecialOffersController');
    });
});



