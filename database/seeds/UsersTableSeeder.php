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
            [
                'name'     => 'Morgan',
                'password' => bcrypt('0000')
            ],
            [
                'name'     => 'Crystal',
                'password' => bcrypt('crystal')
            ],
            [
                'name'     => 'Wissem',
                'password' => bcrypt('wissem')
            ],
            [
                'name'     => 'Gabriel',
                'password' => bcrypt('0000')
            ],
            [
                'name'     => 'Yoann',
                'password' => bcrypt('0000')
            ]
        ]);

        DB::table('role_user')->insert([
            [
                'role_id' => 1,
                'user_id' => 1
            ],
            [
                'role_id' => 2,
                'user_id' => 2
            ],
            [
                'role_id' => 2,
                'user_id' => 3
            ],
            [
                'role_id' => 3,
                'user_id' => 4
            ],
            [
                'role_id' => 3,
                'user_id' => 5
            ]
        ]);
    }
}
