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
        DB::table('roles')->insert(['role' => 'SuperAdmin']);
        DB::table('roles')->insert(['role' => 'Admin']);
        DB::table('roles')->insert(['role' => 'Editor']);
        DB::table('roles')->insert(['role' => 'User']);
        DB::table('roles')->insert(['role' => 'Visitor']);
    }
}
