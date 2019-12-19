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
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, enctype, X-Auth-Token, X-Requested-With, Origin, Authorization, X-CSRF-Token, Accept');

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('user/profile', 'API\UserController@details');
//Route::get('user/profile','API\UserController@update');
Route::put('user/profile-update','API\UserController@update');
Route::get('user/notification','API\NotificationController@getNotification');
Route::post('user/notification/create','API\NotificationController@store');
Route::post('user/image/upload','API\NotificationController@file_store');
Route::get('course/{course}/date/{date}/students','API\AttendanceController@getStudents');
Route::post('course/{course}/date/{date}/attendance','API\AttendanceController@setAttendance');
Route::get('course', 'CourseController@index');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
