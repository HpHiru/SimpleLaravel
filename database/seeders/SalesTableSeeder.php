<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Sale::factory(500)->create()->each(function ($sale) {
            $sale->items()->save(\App\Models\SaleItem::factory()->make());
        });
    }
}
