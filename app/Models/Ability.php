<?php

namespace App\Models;

/**
 * Class Ability
 *
 * @package App\Models
 */
class Ability extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_ability')->withTimestamps();
    }
}
