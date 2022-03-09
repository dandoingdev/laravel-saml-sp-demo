<?php

use App\Http\Controllers\SAMLController;

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

Route::get('login', [SAMLController::class, 'login'])->name('login');
Route::post('logout', [SAMLController::class, 'logout']);
Route::group(['middleware' => ['auth']], function () {
    // protected routes go here
    Route::get('loggedin', [SAMLController::class, 'loggedin']);
});
