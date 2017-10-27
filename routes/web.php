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

Auth::routes();

Route::group(['middleware' => 'web'], function () {
    //Home Page View
    Route::get('/', 'DashboardAdminController@index');
    Route::get('/dashboard', 'DashboardAdminController@index');
    Route::post('/dashboard/getOverviewChartData', 'DashboardAdminController@getOverviewChartData');
    Route::post('/dashboard/getPieChartData', 'DashboardAdminController@getPieChartData');
    Route::post('/dashboard/getBarChartData', 'DashboardAdminController@getBarChartData');

    //Clients
    Route::get('/clients-admin', 'ClientsAdminController@index');
    Route::post('/clients/clients', 'ClientsAdminController@ClientsTable');
    Route::post('/clients/toggleServices', 'ClientsAdminController@toggleServices');
    Route::post('/clients/uploadCSV', 'ClientsAdminController@uploadCSV');
    Route::post('/clients/saveFormat', 'ClientsAdminController@saveFormat');
    Route::post('/clients/getFormat', 'ClientsAdminController@getFormat');
    Route::post('/clients/refreshFormats', 'ClientsAdminController@refreshFormats');
    Route::post('/clients/viewRecord', 'ClientsAdminController@viewRecord');
    Route::post('/clients/addRecord', 'ClientsAdminController@addRecord');
    Route::post('/clients/getRecord', 'ClientsAdminController@getRecord');
    Route::post('/clients/editRecord', 'ClientsAdminController@editRecord');
    Route::post('/clients/deleteRecord', 'ClientsAdminController@deleteRecord');

    //Products
    Route::get('/products-admin', 'ProductsAdminController@index');
    Route::post('/products/clients', 'ProductsAdminController@ClientsTable');
    Route::post('/products/products', 'ProductsAdminController@ProductsTable');
    Route::post('/products/viewRecord', 'ProductsAdminController@viewRecord');
    Route::post('/products/addRecord', 'ProductsAdminController@addRecord');
    Route::post('/products/getRecord', 'ProductsAdminController@getRecord');
    Route::post('/products/editRecord', 'ProductsAdminController@editRecord');
    Route::post('/products/deleteRecord', 'ProductsAdminController@deleteRecord');

    //MIDs
    Route::get('/mids-admin', 'MIDsAdminController@index');
    Route::post('/mids/clients', 'MIDsAdminController@ClientsTable');
    Route::post('/mids/mids', 'MIDsAdminController@MIDsTable');
    Route::post('/mids/uploadCSV', 'MIDsAdminController@uploadCSV');
    Route::post('/mids/saveFormat', 'MIDsAdminController@saveFormat');
    Route::post('/mids/getFormat', 'MIDsAdminController@getFormat');
    Route::post('/mids/refreshFormats', 'MIDsAdminController@refreshFormats');
    Route::post('/mids/viewRecord', 'MIDsAdminController@viewRecord');
    Route::post('/mids/addRecord', 'MIDsAdminController@addRecord');
    Route::post('/mids/getRecord', 'MIDsAdminController@getRecord');
    Route::post('/mids/editRecord', 'MIDsAdminController@editRecord');
    Route::post('/mids/deleteRecord', 'MIDsAdminController@deleteRecord');

    //Orders
    Route::get('/orders-admin', 'OrdersAdminController@index');
    Route::post('/orders/clients', 'OrdersAdminController@ClientsTable');
    Route::post('/orders/orders', 'OrdersAdminController@OrdersTable');
    Route::post('/orders/uploadCSV', 'OrdersAdminController@uploadCSV');
    Route::post('/orders/saveFormat', 'OrdersAdminController@saveFormat');
    Route::post('/orders/getFormat', 'OrdersAdminController@getFormat');
    Route::post('/orders/refreshFormats', 'OrdersAdminController@refreshFormats');
    Route::post('/orders/viewRecord', 'OrdersAdminController@viewRecord');
    Route::post('/orders/addRecord', 'OrdersAdminController@addRecord');
    Route::post('/orders/getRecord', 'OrdersAdminController@getRecord');
    Route::post('/orders/editRecord', 'OrdersAdminController@editRecord');
    Route::post('/orders/deleteRecord', 'OrdersAdminController@deleteRecord');
});
