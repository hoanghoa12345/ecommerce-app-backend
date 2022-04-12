<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([[
            'name' => 'Gói sản phẩm 1',
            'duration' => 4,
            'total_price' => 0
        ], [
            'name' => 'Gói sản phẩm 2',
            'duration' => 2,
            'total_price' => 0
        ], [
            'name' => 'Gói sản phẩm 3',
            'duration' => 6,
            'total_price' => 0
        ]]);
    }
}
