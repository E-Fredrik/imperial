<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomFacility;

class RoomFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Kamar Mandi Dalam',
                'description' => 'Kamar mandi pribadi di dalam kamar (ensuite).',
            ],
            [
                'name' => 'Water Heater',
                'description' => 'Pemanas air untuk mandi nyaman.',
            ],
        ];

        foreach ($facilities as $facility) {
            RoomFacility::updateOrCreate(
                ['name' => $facility['name']],
                $facility
            );
        }
    }
}
