<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role::truncate();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'operateur']);
        Role::create(['name' => 'agent public']);
        Role::create(['name' => 'superviseur']);
    }
}
