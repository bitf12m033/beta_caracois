<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'brand_name' => Str::random(10),
            'product_name' => Str::random(10),
            'category' => Str::random(10),
        ]);
    }
}
