<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Vendor ID auto generate (Freelancers, Own teams .etc)
Route::get('/survey/{projectid}/{vendor}/{country}', 'RedirectController@redirect');

// ID provided by the contract vendors
Route::get('/survey/{projectid}/{vendor}/{country}/lang/', 'RedirectController@withVendorIdRedirect');