<?php

use App\Models\LGA;
use App\Models\Camp;
use Illuminate\Database\Seeder;

class CampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var LGA $LGA
         */
        foreach (LGA::all()->random(20) as $LGA) {
            factory(Camp::class, rand(1,3))->create(['lga_id' => $LGA->id]);
        }
    }
}