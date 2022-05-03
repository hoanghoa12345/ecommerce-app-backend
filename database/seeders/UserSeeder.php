<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'roles' => 'admin'
        ]);
        User::create([
            'name' => 'Hoang Hoa',
            'email' => 'hoa@gmail.com',
            'password' => bcrypt('123456'),
            'roles' => 'admin'
        ]);
        User::create([
            'name' => 'Bao Nho',
            'email' => 'abc@gmail.com',
            'password' => bcrypt('123456'),
            'roles' => 'user'
        ]);
        User::create([
            'name' => 'Test1',
            'email' => 'test1@gmail.com',
            'password' => bcrypt('123456'),
            'roles' => 'user'
        ]);
        User::create([
            'name' => 'Test2',
            'email' => 'test2@gmail.com',
            'password' => bcrypt('123456'),
            'roles' => 'user'
        ]);
    }
}
