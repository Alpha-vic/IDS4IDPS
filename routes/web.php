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
Route::group(['namespace' => 'Pages'], function () {
    //------------ Generic App-Page Routes -----------------------------------------
    Route::group(['as' => 'app.'], function () {
        Route::get('/', ['as' => 'home', 'uses' => 'AppController@index']);
        Route::get('enroll', ['as' => 'enroll_idp', 'uses' => 'AppController@enroll']);
    });

    //------------ Admin Panel Page Routes ----------------------------------------------
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'AdminController@dashboard']);
        Route::get('persons', ['as' => 'persons', 'uses' => 'AdminController@persons']);
        Route::get('camps', ['as' => 'camps', 'uses' => 'AdminController@camps']);
        Route::get('organizations', ['as' => 'organizations', 'uses' => 'AdminController@organizations']);
        Route::get('users', ['as' => 'users', 'uses' => 'AdminController@users']);
        Route::get('locations-states', ['as' => 'locations_states', 'uses' => 'AdminController@locations_states']);
        Route::get('locations-lgas/{state_code}', ['as' => 'locations_lgas', 'uses' => 'AdminController@locations_lgas']);
        Route::get('settings', ['as' => 'settings', 'uses' => 'AdminController@settings']);
        Route::get('sys_log', ['as' => 'sys_log', 'uses' => 'AdminController@sysLog']);
    });

    //------------ Data-Entry-Officer's Panel Page Routes ----------------------------------------------
    Route::group(['as' => 'deo.', 'prefix' => 'deo'], function () {
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DeoController@dashboard']);
        Route::get('persons', ['as' => 'persons', 'uses' => 'DeoController@persons']);
        Route::get('camps', ['as' => 'camps', 'uses' => 'DeoController@camps']);
        Route::get('organizations', ['as' => 'organizations', 'uses' => 'DeoController@organizations']);
    });

    Route::group(['as' => 'account.', 'prefix' => 'account'], function () {
        Route::get('profile', ['as' => 'profile', 'uses' => 'AccountController@profile']);
        Route::get('password', ['as' => 'password', 'uses' => 'AccountController@password']);
        Route::post('change-image', ['as' => 'profile.image', 'uses' => 'AccountController@changeImage']);
    });
});

//-------------Base Routes-----------------------------------------------------
Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'Base'], function () {
    Route::post('add', ['as' => 'add', 'uses' => 'UserController@add']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'UserController@remove']);

    Route::post('update', ['as' => 'update', 'uses' => 'UserController@update']);
    Route::post('photo', ['as' => 'photo', 'uses' => 'UserController@setPhoto']);
    Route::post('change-password', ['as' => 'change_password', 'uses' => 'UserController@changePassword']);
});

Route::group(['as' => 'location.', 'prefix' => 'location', 'namespace' => 'Base'], function () {
    Route::post('add-state', ['as' => 'add_state', 'uses' => 'LocationController@addState']);
    Route::post('update-state', ['as' => 'update_state', 'uses' => 'LocationController@updateState']);
    Route::post('remove-state', ['as' => 'remove_state', 'uses' => 'LocationController@removeState']);
    Route::post('add-lga', ['as' => 'add_lga', 'uses' => 'LocationController@addLga']);
    Route::post('update-lga', ['as' => 'update_lga', 'uses' => 'LocationController@updateLga']);
    Route::post('remove-lga', ['as' => 'remove_lga', 'uses' => 'LocationController@removeLga']);
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
    Route::post('update', ['as' => 'update', 'uses' => 'PersonController@update']);
    Route::post('set-photo', ['as' => 'set_photo', 'uses' => 'PersonController@setPhoto']);
    Route::post('remove', ['as' => 'remove', 'uses' => 'PersonController@remove']);
    Route::post('discard', ['as' => 'discard', 'uses' => 'PersonController@discard']);
});

//-------------Authentication, Registration & Password Reset roues-----------------//
Route::group(['as' => 'auth.', 'namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login', 'uses' => 'LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

    // Registration Routes...
    /*
    Route::get('signup', ['as' => 'signup', 'uses' => 'RegisterController@showRegistrationForm']);
    Route::post('signup', ['as' => 'signup', 'uses' => 'RegisterController@register']);
    */

    // Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.form', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.link', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@reset']);

    // Socialite
    Route::get('auth/{service}/{action}', ['as' => 'social.redirect', 'uses' => 'SocialAuthController@redirectToProvider']);
    Route::get('auth/{service}/{action}/callback', ['as' => 'social.callback', 'uses' => 'SocialAuthController@handleProviderCallback']);
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
