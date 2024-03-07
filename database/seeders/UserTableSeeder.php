<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Joselyn Obando',
                'email' => 'joss@admin.es',
                'phone_number' => '622331145',
                'password' => bcrypt('joss123'),
                'role' => 'admin'
            ],
            [
                'name' => 'Alonso Cruz',
                'email' => 'alonso@user.es',
                'phone_number' => '612345678',
                'password' => bcrypt('alo123'),
                'role' => 'user'
            ]
        ]);
    }
}
