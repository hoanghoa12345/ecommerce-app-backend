<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            SubscriptionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
