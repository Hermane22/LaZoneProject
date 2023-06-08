<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::truncate();
        DB::table('role_user')->truncate();

        $admin =User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $operateur =User::create([
            'name' => 'operateur',
            'email' => 'operateur@operateur.com',
            'password' => Hash::make('password')
        ]);

        $agent_public = User::create([
            'name' => 'agent public',
            'email' => 'agentpublic@agentpublic.com',
            'password' => Hash::make('password')
        ]);

        $superviseur =User::create([
            'name' => 'superviseur',
            'email' => 'superviseur@superviseur.com',
            'password' => Hash::make('password')
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $operateurRole = Role::where('name', 'operateur')->first();
        $agent_publicRole = Role::where('name', 'agent public')->first();
        $superviseurRole = Role::where('name', 'superviseur')->first();

        $admin->roles()->attach($adminRole);
        $operateur->roles()->attach($operateurRole);
        $agent_public->roles()->attach($agent_publicRole);
        $superviseur->roles()->attach($superviseurRole);
    }
}
