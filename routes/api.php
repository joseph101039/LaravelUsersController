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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::resource('projects', 'ProjectsController');

/* Partial Resource routes excluding all display resources.*/

//Route::resource('user', 'UserController')->except('create', 'show', 'edit');


Route::get('users/{account}/account', 'Api\UsersApi\Controller@checkIfAccountExisted');
Route::resource('users', 'Api\UsersApi\Controller')->except('create', 'show', 'edit');


