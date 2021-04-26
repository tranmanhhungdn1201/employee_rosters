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
Route::group(['middleware' => 'checkLogin'], function() {
    Route::get('/', function () {
        return view('create_roster');
    });
    Route::get('/shifts/{id}','ShiftController@getShiftById')->name('getShiftById');
    Route::post('/shifts','ShiftController@addShift')->name('addShift');
    Route::post('/shifts/{id}/update-amount','ShiftController@updateAmountShift')->name('updateAmountShift');
    Route::post('/shifts/update-time','ShiftController@updateTimeShift')->name('updateTimeShift');
    Route::post('/shifts/delete','ShiftController@delShift')->name('delShift');

    Route::post('/rosters','RosterController@createRoster')->name('createRoster');
    Route::get('/rosters/{id}','RosterController@singleRoster')->name('singleRoster');

    Route::get('/users','UserController@userList')->name('userList');
    Route::post('/users/create','UserController@createUser')->name('createUser');

    Route::get('/logout','UserController@logout')->name('logout');
});
Route::get('/login','UserController@login')->name('login');
Route::post('/login','UserController@postlogin')->name('postLogin');