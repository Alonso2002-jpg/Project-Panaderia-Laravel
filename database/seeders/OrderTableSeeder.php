<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
           [
            'user_id' => 1,
            'totalItems' => 1,
            'totalPrice' => 2.5,
            'tax' => 0.52,
            'total' => 3.02
           ],
        ]);
    }
}
