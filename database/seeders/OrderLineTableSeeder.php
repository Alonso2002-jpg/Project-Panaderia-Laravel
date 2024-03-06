<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderLineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_lines')->insert(
            [
                [
                    'order_id' => 1,
                    'product_id' => 'f1c3f5a4-bebd-4619-b136-ba2bcfbd5c9a',
                    'stock' => 1,
                    'unitPrice' => 2.5,
                    'linePrice' => 2.5
                ]
            ]
        );
    }
}
