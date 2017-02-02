<?php

use App\Models\LGA;
use App\Models\State;
use Illuminate\Database\Seeder;

class LGAsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var State $state
         */
        foreach (State::all() as $state) {
            factory(LGA::class, rand(10, 20))->create(['state_id' => $state->id]);
        }
    }
}