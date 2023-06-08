<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
       // \App\Models\Cv::factory(25)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
