<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

Auth::routes(['register' => false,'reset'=>false]);

Route::middleware(['auth'])->group(function(){
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::resource('client', 'ClientController');
    Route::resource('unit', 'UnitController');
    Route::resource('repo', 'RepoController');
    Route::resource('application', 'ApplicationController');
    Route::post('application_import', 'ApplicationController@import')->name('application.import');
    Route::group(['prefix' => 'application/status/'],function(){
        Route::get('active', 'ApplicationController@active')->name('application-status-active');
        Route::get('overdue', 'ApplicationController@overdue')->name('application-status-overdue');
        Route::get('history', 'ApplicationController@history')->name('application-status-history');
    });
    Route::post('pay', 'PaymentController@store')->name('pay');
    Route::resource('user', 'UserController');
});

