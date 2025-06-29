<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WarehouseSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\WarehouseZoneSeeder;
use Database\Seeders\WarehouseSectionSeeder;
use Database\Seeders\WarehouseRackSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            WarehouseSeeder::class,
            WarehouseZoneSeeder::class,
            WarehouseSectionSeeder::class,
            WarehouseRackSeeder::class,
            WarehouseSlotSeeder::class
        ]);
    }
}
