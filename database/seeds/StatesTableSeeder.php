<?php

use App\Models\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 37; ++$i) {
            factory(State::class)->create(['code' => 'ST-'.$i]);
        }
    }
}