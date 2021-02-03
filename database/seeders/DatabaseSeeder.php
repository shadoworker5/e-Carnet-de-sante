<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patients as ModelsPatients;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // ModelsPatients::factory(20)->create();
        Model::unguard();

        $this->call(PermissionsTableSeeder ::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        //$this->call('UsersTableSeeder');

        Model::reguard();
    }
}
