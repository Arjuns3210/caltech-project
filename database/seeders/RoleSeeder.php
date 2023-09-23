<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'permission' => '[]'
            ],
            [
                'role_name' => 'Staff',
                'permission' => '[7,8,9,10,13,14,15,16,19,20,21,22]'
            ]
        ]);
    }
}
