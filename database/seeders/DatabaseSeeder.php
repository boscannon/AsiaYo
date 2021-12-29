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

        for($x=0; $x < 20; $x++){
            Property::factory()
                ->count(1)
                ->has(
                    Room::factory()
                        ->count(10)
                        ->has(Orders::factory()->times(random_int(1000, 9999)))
                )
                ->create();
        }

        // SELECT count(*) as orderCount, property.name from property
        // LEFT JOIN room on property.id = room.property_id
        // LEFT JOIN orders on room.id = orders.room_id
        // GROUP BY property.id
        // ORDER BY orderCount desc
        // LIMIT 10
    }
}
