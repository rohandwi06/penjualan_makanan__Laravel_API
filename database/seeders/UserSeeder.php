<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'rohan',
                'username' => 'rohan',
                'password' => bcrypt('rohan'),
                'role_id' => 1,
            ],
            [
                'nama' => 'manager',
                'username' => 'manager',
                'password' => bcrypt('manager'),
                'role_id' => 2,
            ],
        ]);
    }
}
