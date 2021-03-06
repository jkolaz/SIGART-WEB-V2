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

Route::get('/', 'HomeController@index')->name( 'home.index' );
Route::get('/terms-and-conditions', 'PublicController@termsAndConditions')->name( 'tyc' );
Route::get('/about-us', 'PublicController@aboutUs')->name( 'about-us' );
Route::get('/contact-us', 'ContactUsController@dashboard')->name( 'contact-us' );
Route::get('/confimation/{token}', 'DashboardController@confirmation')->name( 'confirmation' );

Route::group(['middleware' => ['guest']], function(){

    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name( 'login.register' );
    Route::post('/register', 'Auth\RegisterController@register')->name( 'login.register.post' );
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name( 'login.form' );
    Route::post('/login', 'Auth\LoginController@login')->name( 'login.request' );

});

Route::group(['middleware' => ['auth']], function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::prefix( 'dashboard' )->group( function() {
        Route::get( '/', 'DashboardController@index' )->name( 'dashboard' );
        Route::get( '/profile', 'UserController@profile' )->name( 'profile' );
        Route::get( '/settings', 'DashboardController@settings' )->name( 'dashboard.settings' );
    });


    Route::prefix( 'service-request' )->group( function () {
        Route::get( '/', 'ServiceController@getServiceRequest' );
        Route::post( '/generate/', 'ServiceController@generateServiceRequest');
        Route::get( '/{id}/edit/', 'ServiceController@edit' );
        Route::get( '/{id}/send/', 'ServiceController@send' );
        Route::get( '/{id}/delete/', 'ServiceController@delete' );
    });

    Route::prefix( 'customer' )->group( function () {
        Route::get( '/show', 'CustomerController@show' );
        Route::post( '/update', 'CustomerController@update');
    });

    Route::prefix( 'sale-quotation' )->group( function () {
        Route::get( '/{type?}', 'SaleQuotationController@listData' );
        Route::post( '/action/', 'SaleQuotationController@action' );
    });

    Route::prefix( 'service' )->group( function () {
        Route::get( '/', 'ServiceController@listServices' )->name('service');
        Route::post( '/service-order-action/', 'ServiceController@approvedSO' )->name('service.service-order.approved');
    });

    Route::get( '/products', 'ProductController@getProducts' );
    Route::get( '/departaments/', 'StaticController@loadDepartament' );
    Route::get( '/provinces/{departament}', 'StaticController@loadProvince' );
    Route::get( '/districts/{departament}/{province}/', 'StaticController@loadDistrict' );
    Route::get( '/type-document/', 'StaticController@loadTypeDocument' );
    Route::get( '/type-person/', 'StaticController@loadTypePerson' );

});
