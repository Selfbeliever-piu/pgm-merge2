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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/adminreguser', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware(['web','guest']);
//Route::post('/adminreguser', 'Auth\RegisterController@register')->name('register')->middleware(['web','guest']);
Route::get('/update-password', 'CusResetpasswordController@index')->name('updatepassword')->middleware('auth');
Route::post('/update-password', 'CusResetpasswordController@cuspasswordrest')->name('cusresetpassword')->middleware('auth');
Route::get('/showRegistration', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('auth');
Route::post('/showRegistration', 'Auth\RegisterController@register')->name('registerUser');
Route::get('/loginwith', 'Adminconfig\AdminconfigController@userloginwith')->name('loginwith');
Route::post('/loginwith', 'Adminconfig\AdminconfigController@saveuserloginwith')->name('saveuserloginwith');

////////////////

Route::post('/edituser','manageUsers@editUser')->name('editUser');
Route::post('/edit','manageUsers@edit')->name('edit');
Route::get('/edit','manageUsers@edit');
Route::get('/manageroles', 'ManageRoles@index')->name('manageroles')->middleware('auth');
Route::post('/manageroles/save', 'ManageRoles@saveRoles')->name('saveRolePermissions');
Route::post('/manageroles/delete', 'ManageRoles@deleteRoles')->name('deleteRole');
Route::get('/manageusers', 'manageUsers@index')->name('manageusers')->middleware('auth');
Route::get('/deleteusers', 'manageUsers@delete')->name('deleteuser')->middleware('auth');
Route::resource('manageusers', 'ManageUsers'); 