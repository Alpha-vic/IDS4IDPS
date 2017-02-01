<?php

namespace App\Models\Traits;

trait FindByPhone
{
    /**
     * @param $phone
     *
     * @return mixed
     */
    public static function findByPhone($phone)
    {
        return self::findByColumn('phone', $phone)->first();
    }
}