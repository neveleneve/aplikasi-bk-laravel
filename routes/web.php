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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('record');
});

// Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::resource('teachers', 'TeacherController');
    
    Route::resource('students', 'StudentController');

    Route::resource('services', 'ServiceController');
    
    Route::get('subservices/{currentServiceId}/create', 'SubServiceController@create'); 
    Route::post('subservices', 'SubServiceController@store'); 
    Route::delete('subservices/{id}', 'SubServiceController@destroy'); 
    Route::get('subservices/{id}/edit', 'SubServiceController@edit'); 
    Route::put('subservices/{id}', 'SubServiceController@update');
    Route::get('subservices/{id}', 'SubServiceController@show');
    Route::get('subservices/', 'SubServiceController@index');  
    // Route::resource('subservices', 'SubserviceController');

    Route::resource('record', 'RecordController');
    Route::get('record/{record}/pdf', 'RecordController@pdf');    

    Route::get('api/students/{search?}', 'StudentController@api'); 
});