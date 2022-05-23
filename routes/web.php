<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('', function () {
      dd(app('url')->asset('uploads/company-logo/248.png'));
      

});

Route::group(['prefix' => 'api'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'resume'], function () {
            Route::get('','ResumeController@index');
            Route::get('{experienceId}','ResumeController@show');
            Route::post('','ResumeController@store');
            Route::post('{experienceId}','ResumeController@update');
            Route::delete('{experienceId}','ResumeController@destroy');
        });
    });
    
});


// $router->group(['middleware' => ['auth:api']], function () {
//     Router::get('')
// });

