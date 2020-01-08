<?php

use Illuminate\Http\Request;


Route::group(['prefix' => 'v1'], function () {
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('checkDomain', 'Auth\RegisterController@checkDomain');
});

Route::group(['middleware' => ['auth:api', 'cors'], 'prefix' => 'v1'], function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'budgets'], function () {
        Route::post('forSelect','BudgetsController@forSelect');
        Route::resource('resource','BudgetsController');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::post('forSelect','ProductsController@forSelect');
        Route::resource('resource','ProductsController');
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::post('forSelect','ClientsController@forSelect');
        Route::resource('resource','ClientsController');
    });
});
