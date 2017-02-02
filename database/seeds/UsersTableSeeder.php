<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create user with and admin and academia roles
        factory(User::class)->create([
            'email' => 'admin@domain.com',
            'first_name' => 'Musa',
            'last_name' => 'Umar',
            'password' => bcrypt('admin-secret'),
        ])->each(function (User $user) {
            $user->roles()->attach([
                Role::findByName(User::ROLE_ADMIN)->id,
                Role::findByName(User::ROLE_DEO)->id,
            ]);
        });

        //Creates users with password = secret-password
        $RID = Role::findByName(User::ROLE_DEO)->id;
        factory(User::class, 5)->create()->each(function (User $user) use ($RID) {
            $user->roles()->attach($RID);
        });
    }
}
