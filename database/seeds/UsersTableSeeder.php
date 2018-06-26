<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'morgan',
            'password' => bcrypt('0000')
            // 'connect'  => '0'
        ]);
        DB::table('users')->insert([
            'name'     => 'crystal',
            'password' => bcrypt('crystal')
            // 'connect'  => '0'
        ]);
        DB::table('users')->insert([
            'name'     => 'wissem',
            'password' => bcrypt('wissem')
            // 'connect'  => '0'
        ]);
    }
}
