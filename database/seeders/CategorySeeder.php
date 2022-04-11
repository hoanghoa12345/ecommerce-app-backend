<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create( [
            'id'=>1,
            'slug'=>'bot-giat-nuoc-giat',
            'name'=>'Bột giặt, nước giặt',
            'created_at'=>'2022-03-25 20:20:47',
            'updated_at'=>'2022-03-25 20:20:47'
        ] );

        Category::create( [
            'id'=>2,
            'slug'=>'nuoc-xa-nuoc-tay',
            'name'=>'Nước xả, nước tẩy',
            'created_at'=>'2022-03-28 23:11:07',
            'updated_at'=>'2022-03-28 23:11:07'
        ] );

        Category::create( [
            'id'=>3,
            'slug'=>'nuoc-rua-chen',
            'name'=>'Nước rửa chén',
            'created_at'=>'2022-03-28 23:18:16',
            'updated_at'=>'2022-03-28 23:18:16'
        ] );
    }
}
