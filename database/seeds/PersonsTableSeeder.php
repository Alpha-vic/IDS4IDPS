<?php

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Camp;
use App\Models\LGA;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camps = Camp::all();
        $lgas = LGA::all();
        factory(Person::class, 50)->create()->each(function (Person $person) use ($camps, $lgas){
            $person->camp()->associate($camps->random()->id);
            $person->lga()->associate($lgas->random()->id);
            $person->save();
        });
    }

}
