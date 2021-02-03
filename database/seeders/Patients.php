<?php

namespace Database\Seeders;

use App\Models\Patients as ModelsPatients;
use Illuminate\Database\Seeder;

class Patients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsPatients::factory(10)->create();
    }
}
