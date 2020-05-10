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
    return redirect()->route('login');
});

// Auth::routes();

Route::get('/login', 'Frontend\Auth\LoginController@showLoginForm')->name('login');

Route::post('/login', 'Frontend\Auth\LoginController@login')->name('post.login');

Route::get('/logout','Frontend\Auth\LoginController@logout')->name('logout');

Route::get('home', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => 'is_admin'], function(){
    //mst_users
    Route::get('mst-users', 'Backend\MstUserController@index')->name('mst_users.index');
    Route::get('mst-users/get-data-users','Backend\MstUserController@getDataUsers')->name('mst_users.get_data_user');
    Route::get('mst-users/add-user','Backend\MstUserController@addUser')->name('mst_users.add');
    Route::post('mst-users/add-user','Backend\MstUserController@postAdd')->name('mst_users.create');
    Route::get('mst-users/edit-user','Backend\MstUserController@editUser')->name('mst_users.edit');
    Route::post('mst-users/edit-user','Backend\MstUserController@postEdit')->name('mst_users.update');
    Route::get('mst-users/deactive-active','Backend\MstUserController@deactiveAndActive')->name('mst_users.deactiveandactive');
    Route::get('mst-users/delete','Backend\MstUserController@delete')->name('mst_users.delete');
    Route::get('mst-users/reset-pass','Backend\MstUserController@resetPass')->name('mst_users.resetpass');
    

    //mst_unit
    Route::get('mst-unit', 'Backend\MstUnitController@index')->name('mst_unit.index');
    Route::get('mst-unit/get-data-units','Backend\MstUnitController@getDataMstUnit')->name('mst_unit.get_data_unit');
    Route::post('mst-unit/create', 'Backend\MstUnitController@create')->name('mst_unit.create');
    Route::post('mst-unit/update', 'Backend\MstUnitController@update')->name('mst_unit.update');
    Route::get('mst-unit/delete', 'Backend\MstUnitController@delete')->name('mst_unit.delete');


    //mst_position
    Route::get('mst-position', 'Backend\MstPositionController@index')->name('mst_position.index');
    Route::get('mst-position/get-data-positions','Backend\MstPositionController@getDataMstPosition')->name('mst_position.get_data_position');
    Route::post('mst-position/create', 'Backend\MstPositionController@create')->name('mst_position.create');
    Route::post('mst-position/update', 'Backend\MstPositionController@update')->name('mst_position.update');
    Route::get('mst-position/delete', 'Backend\MstPositionController@delete')->name('mst_position.delete');

    //mst_title
    Route::get('mst-title', 'Backend\MstTitleController@index')->name('mst_title.index');
    Route::get('mst-title/get-data-title','Backend\MstTitleController@getDataMstTitle')->name('mst_title.get_data_title');
    Route::post('mst-title/create', 'Backend\MstTitleController@create')->name('mst_title.create');
    Route::post('mst-title/update', 'Backend\MstTitleController@update')->name('mst_title.update');
    Route::get('mst-title/delete', 'Backend\MstTitleController@delete')->name('mst_title.delete');



    //mst_class
    Route::get('mst-class', 'Backend\MstClassController@index')->name('mst_class.index');
    Route::get('mst-class/get-data-class','Backend\MstClassController@getDataMstClass')->name('mst_class.get_data_class');
    Route::post('mst-class/create', 'Backend\MstClassController@create')->name('mst_class.create');
    Route::post('mst-class/update', 'Backend\MstClassController@update')->name('mst_class.update');
    Route::get('mst-class/delete', 'Backend\MstClassController@delete')->name('mst_class.delete');



    //mst_semester
    Route::get('mst-semester', 'Backend\MstSemesterController@index')->name('mst_semester.index');
    Route::get('mst-semester/get-data-semester','Backend\MstSemesterController@getDataMstSemester')->name('mst_semester.get_data_semester');
    Route::post('mst-semester/create', 'Backend\MstSemesterController@create')->name('mst_semester.create');
    Route::post('mst-semester/update', 'Backend\MstSemesterController@update')->name('mst_semester.update');
    Route::get('mst-semester/delete', 'Backend\MstSemesterController@delete')->name('mst_semester.delete');

    //mst_term
    Route::post('mst-term/create', 'Backend\MstTermController@create')->name('mst_term.create');
    Route::post('mst-term/update', 'Backend\MstTermController@update')->name('mst_term.update');
    Route::get('mst-term/delete', 'Backend\MstTermController@delete')->name('mst_term.delete');

});

//mst_term
Route::get('mst-term', 'Backend\MstTermController@index')->name('mst_term.index');
Route::get('mst-term/get-data-term', 'Backend\MstTermController@getDataMstTerm')->name('mst_term.get_data_term');

Route::group(['middleware' => 'is_user'], function(){
    //mst_mission
    Route::get('mst-mission', 'Backend\MstMissionController@index')->name('mst_mission.index');
    Route::get('mst-mission/get-data-mission', 'Backend\MstMissionController@getDataMstMission')->name('mst_mission.get_data_mission');
    Route::get('mst-mission/add-mision', 'Backend\MstMissionController@addMission')->name('mst_mission.add');
    Route::post('mst-mission/add-mision', 'Backend\MstMissionController@create')->name('mst_mission.create');
    
    Route::get('mst-mission/edit-mission','Backend\MstMissionController@edit')->name('mst_mission.edit');
    Route::post('mst-mission/edit-mission','Backend\MstMissionController@editPost')->name('mst_mission.editPost');

    Route::get('mst-mission/delete','Backend\MstMissionController@delete')->name('mst_mission.delete');

    Route::post('mst-mission/get-data-term','Backend\MstMissionController@getMstTerm')->name('mst_mission.get_data_term');


});

Route::get('mst-users/change-info', 'Backend\MstUserController@showChangeInfo')->name('mst_users.change_info');
Route::post('mst-users/change-info', 'Backend\MstUserController@postChangeInfo')->name('mst_users.post_change_info');

Route::get('mst-users/change-pass', 'Backend\MstUserController@changePass')->name('mst_users.changepass');
Route::post('mst-users/change-pass', 'Backend\MstUserController@postChangePass')->name('mst_users.postchangepass');
