<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name'=>'baju muslim',
                'sku'=>'mos-01',
                'qty'=>10,
                'reserved_qty'=>10,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'price'=>20000
            ],
            [
                'name'=>'baju koko',
                'sku'=>'mos-02',
                'qty'=>1,
                'reserved_qty'=>1,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'price'=>10000
            ]
        ];

        foreach ($products as $item) {
            DB::table('products')->insert($item);
        }

    }
}
