<?php

namespace App\Models\Traits;

trait FindByCode
{
    public static function findByCode($code)
    {
        return self::findByColumn('code', $code)->first();
    }
}