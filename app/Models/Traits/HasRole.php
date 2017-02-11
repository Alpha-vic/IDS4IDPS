<?php

namespace App\Models\Traits;

use App\Models\Role;

trait HasRole
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * @param Role $role
     *
     * @return mixed
     */
    public function hasRole(Role $role)
    {
        return $this->roles->contains($role);
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        $role = Role::where('name', self::ROLE_ADMIN)->first();

        return $this->hasRole($role);
    }

    /**
     * @return mixed
     */
    public function isDEO()
    {
        $role = Role::where('name', self::ROLE_DEO)->first();

        return $this->hasRole($role);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function abilities()
    {
        $abilities = collect();
        foreach ($this->roles as $role) {
            $abs = Role::all()->find($role->id)->abilities;
            foreach ($abs as $ab) {
                if (!$abilities->contains($ab->key)) {
                    $abilities->put($ab->key, $ab);
                }
            }
        }

        return $abilities;
    }

    /**
     * @return bool
     */
    public function hasAllAbilities()
    {
        $user_abilities = $this->abilities();
        foreach ($user_abilities as $u_a) {
            if ($u_a->key === '*') {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $ability
     *
     * @return bool
     */
    public function hasAbility($ability)
    {
        foreach ($this->abilities() as $u_a) {
            if ($u_a->key === '*' || strcasecmp($u_a->key, $ability) === 0) {
                return true;
            }
        }

        return false;
    }
}