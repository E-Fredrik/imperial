<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Image;

class RoomImagesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $letters = range('A', 'I');

        foreach ($letters as $letter) {
            $room = Room::where('room_number', $letter)->first();

            if (! $room) {
                $this->command->warn("Room with room_number \"{$letter}\" not found. Skipping.");
                continue;
            }

            // Regular room image
            $imagePath = 'images/rooms/' . strtolower($letter) . '.jpg';
            $image = Image::firstOrCreate(
                ['image_path' => $imagePath],
                ['description' => 'Room ' . $letter, 'is_featured' => false]
            );

            // Attach regular image to room
            $room->images()->syncWithoutDetaching([$image->id]);

            // 360° image for each room
            $image360Path = 'images/rooms/' . strtolower($letter) . '360.jpeg';
            $image360 = Image::updateOrCreate(
                ['image_path' => $image360Path],
                [
                    'description' => 'Room ' . $letter . ' 360° view',
                    'is_360' => true,
                    'is_featured' => false
                ]
            );

            // Attach 360° image to room
            $room->images()->syncWithoutDetaching([$image360->id]);
            
            $this->command->info("✓ Attached images to Room {$letter}: regular + 360°");
        }
    }
}
