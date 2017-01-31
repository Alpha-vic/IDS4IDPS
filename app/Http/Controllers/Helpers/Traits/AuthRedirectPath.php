<?php

namespace App\Http\Controllers\Helpers\Traits;

trait AuthRedirectPath {

    /**
     * @return string
     */
    public function redirectPath()
    {
        return self::getRedirectPath();
    }

    /**
     * @return string
     */
    public static function getRedirectPath()
    {
        return redirect()->intended()->getTargetUrl();
    }

}
