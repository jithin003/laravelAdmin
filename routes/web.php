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
	//Subject or Category
	Route::get('subject', 'CategoryController@show')->name('subject');
	Route::get('subject/create', 'CategoryController@create')->name('subject.create');
	Route::post('subject', 'CategoryController@store')->name('subject.store');
	Route::get('subject/{id}/edit', 'CategoryController@edit')->name('subject.edit');
	Route::put('subject/{id}', 'CategoryController@update')->name('subject.update');
	Route::delete('subject/{id}', 'CategoryController@destroy')->name('subject.destroy');

	///course
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
	Route::get('question/list','ExamController@questionIndex')->name('question.list');
	Route::get('question/create','ExamController@createQuestion')->name('question.create');
	Route::post('exam','ExamController@storeExam')->name('exam.store');
	Route::post('question/stote','ExamController@storeQuestion')->name('question.store');
	Route::delete('exam/{id}', 'ExamController@destroy')->name('exam.destroy');
	Route::get('exam/{id}/edit', 'ExamController@edit')->name('exam.edit');
	Route::post('exam/{id}/update', 'ExamController@update')->name('exam.update');
	Route::get('exam/{id}/addquestion', 'ExamController@addquestion')->name('exam.addquestion');
	Route::get('exam/{id}/view', 'ExamController@viewExam')->name('exam.view');
	Route::delete('exam/{id}/question/{qid}', 'ExamController@removeQuestion')->name('question.removequestion');
	Route::post('examquestion/stote','ExamController@storeExamQuestion')->name('examquestion.store');
	Route::put('exam/{id}/editquestion','ExamController@updateExamQuestion')->name('examquestion.update');
	Route::get('exam/course', 'ExamController@getExamCourse')->name('exam.addcourse');
	Route::post('exam/course', 'ExamController@setExamCourse')->name('exam.addcourse');
	Route::get('exam/{id}/report','ExamController@getReportView')->name('exam.report');
	Route::get('exam/{examid}/course/{courseid}/report','ExamController@getReport');
});

