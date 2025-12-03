<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => 'A',
                'price' => 1850000,
                'length' => 4,
                'width' => 3,
                'type' => 'single',
                'floor' => 1,
                'status' => 'available',
            ],
            [
                'room_number' => 'B',
                'price' => 1850000,
                'length' => 4,
                'width' => 3,
                'type' => 'single',
                'floor' => 1,
                'status' => 'available',
            ],
            [
                'room_number' => 'C',
                'price' => 4500000,
                'length' => 5,
                'width' => 4,
                'type' => 'double',
                'floor' => 2,
                'status' => 'available',
            ],
            [
                'room_number' => 'D',
                'price' => 4500000,
                'length' => 5,
                'width' => 4,
                'type' => 'double',
                'floor' => 2,
                'status' => 'available',
            ],
            [
                'room_number' => 'E',
                'price' => 8000000,
                'length' => 6,
                'width' => 5,
                'type' => 'suite',
                'floor' => 3,
                'status' => 'available',
            ],
            [
                'room_number' => 'F',
                'price' => 8000000,
                'length' => 6,
                'width' => 5,
                'type' => 'suite',
                'floor' => 3,
                'status' => 'available',
            ],
            [
                'room_number' => 'G',
                'price' => 12000000,
                'length' => 8,
                'width' => 6,
                'type' => 'presidential',
                'floor' => 4,
                'status' => 'available',
            ],
            [
                'room_number' => 'H',
                'price' => 12000000,
                'length' => 8,
                'width' => 6,
                'type' => 'presidential',
                'floor' => 4,
                'status' => 'available',
            ],
            [
                'room_number' => 'I',
                'price' => 6000000,
                'length' => 5.5,
                'width' => 4.5,
                'type' => 'deluxe',
                'floor' => 2,
                'status' => 'available',
            ],
        ];

        foreach ($rooms as $data) {
            Room::updateOrCreate(
                ['room_number' => $data['room_number']],
                $data
            );
        }
    }
}
