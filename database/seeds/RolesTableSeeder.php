<?php

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
        DB::table('roles')->insert([
            ['role' => 'SuperAdmin'],
            ['role' => 'Admin'],
            ['role' => 'Editor'],
            ['role' => 'User'],
            ['role' => 'Visitor']
        ]);
    }
}
