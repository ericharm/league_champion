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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
// });

Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::post('password/reset', 'Auth\ResetPasswordController@reset')
  ->name('password.reset');

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
  ->name('password.email');

Route::resource('leagues', 'LeaguesController', ['except' => [
    'create', 'edit'
]]);

// Auth::routes();
