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

Route::get('ping', function() {
    return 'pong';
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'FabelioController@showSubmit');
Route::post('/', 'FabelioController@submit');
Route::get('/products', 'FabelioController@showProducts');
Route::get('/products/{id}', 'FabelioController@showProductById');
