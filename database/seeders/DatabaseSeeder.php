<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Room;
use App\Models\Orders;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Property::factory()
            ->count(10)
            ->has(
                Room::factory()
                    ->count(10)
                    ->has(Orders::factory()->count(100))
            )
            ->create();
    }
}
