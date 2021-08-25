<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::resource('client', 'ClientController');
Route::resource('unit', 'UnitController');
Route::resource('application', 'ApplicationController');
Route::group(['prefix' => 'application/status/'],function(){
    Route::get('active', 'ApplicationController@active')->name('application-status-active');
    Route::get('overdue', 'ApplicationController@overdue')->name('application-status-overdue');
    Route::get('history', 'ApplicationController@history')->name('application-status-history');
});
Route::post('pay', 'PaymentController@store')->name('pay');

