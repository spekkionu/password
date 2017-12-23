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

Route::get('/', 'HomeController@index')->name('home');


Route::middleware(['auth'])->prefix('site')->group(function () {
    Route::get('/', 'SiteController@index');
    Route::post('/', 'SiteController@create');
    Route::prefix('{site}')->group(function () {
        Route::get('/', 'SiteController@show')->name('site');
        Route::patch('/', 'SiteController@update');
        Route::delete('/', 'SiteController@destroy');

        Route::prefix('section')->group(function () {
            Route::post('/', 'SectionController@create');
            Route::prefix('{section}')->group(function () {
                Route::patch('/', 'SectionController@update');
                Route::delete('/', 'SectionController@destroy');

                Route::prefix('data')->group(function () {
                    Route::post('/', 'DataController@create');
                    Route::prefix('{data}')->group(function () {
                        Route::patch('/', 'DataController@update');
                        Route::delete('/', 'DataController@destroy');
                    });
                });
            });
        });
    });
});
