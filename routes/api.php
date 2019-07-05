<?php

use Illuminate\Http\Request;

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

Route::post('/events', 'EventController@store');
Route::put('/events/{event}', 'EventController@update');
Route::delete('/events', 'EventController@delete');

Route::get('/event-dates', 'EventDateController@index');