<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListsController;
use Laravel\Fortify\Fortify;

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
    return response()->redirectTo('/login');
});

Route::middleware(['auth:sanctum', 'verified', 'inertia'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')
        ->name('dashboard');

    Route::resource('lists', 'ListsController')
        ->only(['index', 'create', 'store']);

    Route::get('lists/{waitlist}', 'ListsController@show')
        ->name('lists.show');

    Route::delete('lists/{waitlist}', 'ListsController@delete')
        ->name('lists.delete');

    Route::get('lists/{waitlist}/export', 'ListsController@export')
        ->name('lists.export');

    // Subscribers
    Route::delete('subscribers/{subscriber}', 'SubscribersController@delete')
        ->name('subscribers.delete');
});
