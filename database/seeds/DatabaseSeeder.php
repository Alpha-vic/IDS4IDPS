<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AbilitiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(LGAsTableSeeder::class);
        $this->call(CampsTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(PersonsTableSeeder::class);
    }

}
