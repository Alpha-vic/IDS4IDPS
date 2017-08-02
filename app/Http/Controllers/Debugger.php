<?php

namespace App\Http\Controllers;

class Debugger extends Controller
{
    public static function routes()
    {
        if (config('app.debug')) {
            \Route::group(['as' => 'debug.', 'prefix' => 'debug'], function () {
                $className = class_basename(self::class);

                \Route::get('routes', ['as' => 'routes', 'uses' => $className.'@showRoutes']);

                \Route::get('phpinfo', ['as' => 'phpinfo', 'uses' => $className.'@phpInfo']);
            });
        }
    }

    public static function showRoutes()
    {
        $data['routes'] = \Route::getRoutes();

        return view('debug.routes', $data);
    }

    public static function phpInfo()
    {
        phpinfo();
    }
}