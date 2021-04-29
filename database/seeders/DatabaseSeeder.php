<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(10)->create();

        \App\Models\Shop::factory(10)->create();

        \App\Models\Model\Product::factory(50)->create();

        \App\Models\Model\Review::factory(300)->create();
    }
}
