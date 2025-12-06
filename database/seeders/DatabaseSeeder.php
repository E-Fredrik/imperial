<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\RoomFacilitySeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoomImagesSeeder;
use Database\Seeders\RoomFacilityImagesSeeder;
use Database\Seeders\InformationSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            RoomFacilitySeeder::class,
            RoomImagesSeeder::class,
            RoomFacilityImagesSeeder::class,
            InformationSeeder::class
        ]);
    }
}
