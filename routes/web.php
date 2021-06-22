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
        Route::get('/shifts/remove-shift-register/{id}','ShiftController@removeShift')->name('removeShift');
        Route::get('/shifts/check-slot/{id}','ShiftController@registerShift')->name('registerShift');
        Route::get('/rosters/{id}','RosterController@singleRoster')->name('singleRoster');
    Route::group(['middleware' => 'checkRole'], function() {
        Route::get('/','MasterController@index')->name('index');
        //shifts
        Route::get('/shifts/{id}','ShiftController@getShiftById')->name('getShiftById');
        Route::post('/shifts','ShiftController@addShift')->name('addShift');
        Route::post('/shifts/{id}/update-amount','ShiftController@updateAmountShift')->name('updateAmountShift');
        Route::post('/shifts/update-time','ShiftController@updateTimeShift')->name('updateTimeShift');
        Route::post('/shifts/delete','ShiftController@delShift')->name('delShift');

        //rosters
        Route::get('/create','RosterController@viewCreateRoster')->name('viewCreateRoster');
        Route::get('/rosters/{branchID}/list','RosterController@listRoster')->name('listRoster');
        Route::get('/rosters/{branchID}/datatables-list','RosterController@getListRosterDatatables')->name('getListRosterDatatables');
        Route::post('/rosters','RosterController@createRoster')->name('createRoster');
        Route::get('/rosters/{id}/export','RosterController@exportRoster')->name('exportRoster');

        //users
        Route::post('/users/create','UserController@createUser')->name('createUser');
        Route::post('/users/edit','UserController@editUser')->name('editUser');
        Route::post('/users/delete/{userID}','UserController@deleteUser')->name('deleteUser');
        Route::get('/users','UserController@userList')->name('userList');
        Route::get('/users/datatables/getList','UserController@getUserListDatatables')->name('getUserListDatatables');

        //settings
        Route::get('/settings','SettingController@index')->name('setting.index');
        Route::post('/settings/create','SettingController@createBranch')->name('setting.createBranch');
    });
    Route::get('/logout','UserController@logout')->name('logout');
});
Route::get('/login','UserController@login')->name('login');
Route::post('/login','UserController@postlogin')->name('postLogin');