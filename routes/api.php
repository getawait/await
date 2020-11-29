<?php

use App\Http\Middleware\ForceXmlHttpRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->middleware('throttle:10,1')
    ->middleware(ForceXmlHttpRequest::class)
    ->name('api.v1.')
    ->namespace('Api\v1')
    ->group(function () {
        Route::prefix('subscribers')->group(function () {
            Route::get('', 'SubscribersController@index');
            Route::post('', 'SubscribersController@store');
            Route::get('/{subscriber:id}', 'SubscribersController@show');
        });
    });
