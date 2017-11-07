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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('password.change');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('password.change');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    $this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('password.change');
    $this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('password.change');

    Route::redirect('/', 'home', 301);
    Route::get('home', 'Admin\HomeController@index')->name('home');

    Route::resource('abilities', 'Admin\AbilitiesController');
    Route::post('abilities_mass_destroy', ['uses' => 'Admin\AbilitiesController@massDestroy', 'as' => 'abilities.mass_destroy']);

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    Route::resource('organizations', 'Admin\OrganizationsController');
    Route::post('organizations_mass_destroy', ['uses' => 'Admin\OrganizationsController@massDestroy', 'as' => 'organizations.mass_destroy']);

});
