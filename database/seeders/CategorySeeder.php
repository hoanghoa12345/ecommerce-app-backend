<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Bột giặt, nước giặt',
                'slug' => 'bot-giat-nuoc-giat'
            ],[
                'name' => 'Nước xả, nước tẩy',
                'slug' => 'nuoc-xa-nuoc-tay'
            ],
        ]);
    }
}
