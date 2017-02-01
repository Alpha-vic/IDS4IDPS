<?php

namespace App\Models\Traits;

trait FindByEmail
{
    /**
     * @param $email
     *
     * @return mixed
     */
    public static function findByEmail($email)
    {
        return self::findByColumn('email', $email)->first();
    }
}