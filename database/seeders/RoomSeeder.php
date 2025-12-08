<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing rooms
        DB::table('rooms')->truncate();
        
        // Floor 1 - 7 rooms (A-G)
        $floor1Rooms = [
            ['room_number' => 'A', 'floor' => 1, 'type' => 'Single', 'status' => 'available'],
            ['room_number' => 'B', 'floor' => 1, 'type' => 'Single', 'status' => 'available'],
            ['room_number' => 'C', 'floor' => 1, 'type' => 'Single', 'status' => 'booked'],
            ['room_number' => 'D', 'floor' => 1, 'type' => 'Single', 'status' => 'available'],
            ['room_number' => 'E', 'floor' => 1, 'type' => 'Single', 'status' => 'available'],
            ['room_number' => 'F', 'floor' => 1, 'type' => 'Single', 'status' => 'available'],
            ['room_number' => 'G', 'floor' => 1, 'type' => 'Single', 'status' => 'available'],
        ];
        
        // Floor 2 - 2 rooms (H-I)
        $floor2Rooms = [
            ['room_number' => 'H', 'floor' => 2, 'type' => 'Single', 'status' => 'available'],
            ['room_number' => 'I', 'floor' => 2, 'type' => 'Single', 'status' => 'available'],
        ];
        
        $allRooms = array_merge($floor1Rooms, $floor2Rooms);
        
        foreach ($allRooms as $room) {
            Room::create([
                'room_number' => $room['room_number'],
                'floor' => $room['floor'],
                'type' => $room['type'],
                'length' => 3.0,
                'width' => 2.5,
                'price' => 1850000,
                'status' => $room['status'],
            ]);
        }
        
        $this->command->info('✓ Created ' . count($allRooms) . ' rooms');
    }
}
