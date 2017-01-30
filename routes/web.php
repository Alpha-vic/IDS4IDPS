<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//-------------Base Routes------------------------------------------------
Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'Base'], function () {
    Route::post('add', ['as' => 'add', 'uses' => 'UserController@add']);
    Route::post('update', ['as' => 'update', 'uses' => 'UserController@update']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'UserController@remove']);
});

Route::group(['as' => 'location.', 'prefix' => 'location', 'namespace' => 'Base'], function () {
    Route::post('add', ['as' => 'add', 'uses' => 'LocationController@add']);
    Route::post('update', ['as' => 'update', 'uses' => 'LocationController@update']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'LocationController@remove']);
});

Route::group(['as' => 'camp.', 'prefix' => 'camp', 'namespace' => 'Base'], function () {
    Route::post('add', ['as' => 'add', 'uses' => 'CampController@add']);
    Route::post('update', ['as' => 'update', 'uses' => 'CampController@update']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'CampController@remove']);
});

Route::group(['as' => 'organization.', 'prefix' => 'organization', 'namespace' => 'Base'], function () {
    Route::post('add', ['as' => 'add', 'uses' => 'OrganizationController@add']);
    Route::post('update', ['as' => 'update', 'uses' => 'OrganizationController@update']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'OrganizationController@remove']);
});

Route::group(['as' => 'idp.', 'prefix' => 'idp', 'namespace' => 'Base'], function () {
    Route::post('add', ['as' => 'add', 'uses' => 'PersonController@add']);
    Route::post('update', ['as' => 'update', 'uses' => 'PersonController@update']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'PersonController@remove']);
});

//------------ Admin Panel Routes ----------------------------------------------
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Pages'], function () {
    Route::get('camps', ['as'=>'camps','uses'=>'AdminController@camps']);
});

//------------ For troubleshooting purposes and  testing purposes --------------
if (config('app.env') === 'local' or config('app.debug')) {
    Route::group(['as' => 'debug.', 'prefix' => 't'], function () {

        Route::get('/routes', [
            'as' => 'routes', 'uses' => function () {
                $data['routes'] = \Route::getRoutes();

                return view('debug.routes', $data);
            }
        ]);

        Route::get('phpinfo', [
            'as' => 'phpinfo', 'uses' => function () {
                phpinfo();
            }
        ]);
    });
}
