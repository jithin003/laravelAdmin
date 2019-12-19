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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
	Route::get('importExportView', 'UserController@importExportView')->name('importview');

	Route::get('export', 'UserController@export')->name('export');

	Route::post('import', 'UserController@import')->name('import');

	Route::get('usercourse', 'CourseController@index');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	//course
	Route::get('course', 'CourseController@show')->name('course');
	Route::get('course/create', 'CourseController@create')->name('course.create');
	Route::post('course', 'CourseController@store')->name('course.store');
	Route::get('course/{id}/edit', 'CourseController@edit')->name('course.edit');
	Route::put('course/{id}', 'CourseController@update')->name('course.update');
	Route::delete('course/{id}', 'CourseController@destroy')->name('course.destroy');
	///Profile
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	//Notifications
	Route::get('notifications', function () {
		return view('notification.dashboard');
	})->name('notifications');

	Route::get('notification/create', function () {
		return view('notification.create');
	})->name('notification.create');
	Route::post('notification', 'NotificationController@store')->name('notification.store');
	Route::get('notification/{id}/edit', 'CourseController@edit')->name('notification.edit');
	Route::put('notification/{id}', 'NotificationController@update')->name('notification.update');
	Route::delete('notification/{id}', 'NotificationController@destroy')->name('notification.destroy');
	Route::get('notification/list/{type}','NotificationController@index')->name('notification.list');

	//Attendance
	Route::get('attendance', function () {
		return view('attendance.dashboard');
	})->name('attendance');
	Route::get('attendance/list','AttendanceController@index')->name('attendance.list');
	Route::get('attendance/create','AttendanceController@index')->name('attendance.create');

	//Exam
	Route::get('exam', function () {
		return view('exam.dashboard');
	})->name('exam');
	Route::get('exam/list','ExamController@index')->name('exam.list');
	Route::get('exam/create','ExamController@createExam')->name('exam.create');
	Route::get('question/list','ExamController@index')->name('question.list');
	Route::get('question/create','ExamController@createQuestion')->name('question.create');
	Route::post('exam','ExamController@storeExam')->name('exam.store');

});

