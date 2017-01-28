<?php

namespace App\Models;

/**
 * Class Role
 *
 * @package App\Models
 */
class Role extends Model
{
    /**
     * @param $name
     *
     * @return mixed
     */
    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'role_ability')->withTimestamps();
    }

}
