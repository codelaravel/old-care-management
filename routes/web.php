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

Route::group(['middleware' => 'sentinelauth'], function () {
    Route::get('/dashboard', 'ProfileController@index');
    Route::get('/profile/{slug}', 'ProfileController@profile');
    Route::post('/logout', 'Auth\LoginController@logout');
});

Route::group(['middleware' => 'sentinelguest'], function () {
    Route::get('/login', 'Auth\LoginController@login');
    Route::post('/login', 'Auth\LoginController@postLogin');
    Route::get('/register', 'Auth\RegistrationController@register');
    Route::post('/register', 'Auth\RegistrationController@postRegister');
    Route::get('/activate/{email}/{code}', 'Auth\ActivationController@activate');

    Route::get('/password/reset', 'Auth\ForgotPasswordController@forgotPassword');
    Route::post('/password/reset', 'Auth\ForgotPasswordController@postForgotPassword');
    Route::get('/password/reset/{email}/{resetCode}', 'Auth\ForgotPasswordController@resetPassword');
    Route::post('/password/reset/{email}/{resetCode}', 'Auth\ForgotPasswordController@postResetPassword');

});





