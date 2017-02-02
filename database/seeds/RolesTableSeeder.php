<?php

use App\Models\Ability;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //An extra role having some abilities,
        //just so we can have something different from admin and academia
        factory(Role::class)->create()
                ->each(function (Role $role) {
                    $abilities = Ability::all()->except(1)->random(2);
                    foreach ($abilities as $ability) {
                        $role->abilities()->attach($ability->id);
                    }
                });
    }

}
