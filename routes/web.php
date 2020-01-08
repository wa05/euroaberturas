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

Route::get('login', 'Auth\LoginController@login')->name('login');

Route::get('/', function() {
    return redirect()->route('frontend');
});

Route::get('euro/{any?}', function () {
    return file_get_contents(public_path().'/nexarg/index.html');
})->where('any', '.*')->name('frontend');
