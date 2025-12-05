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

            // file expected at public/images/rooms/{lowercase}.jpg
            $imagePath = 'images/rooms/' . strtolower($letter) . '.jpg';

            $image = Image::firstOrCreate(
                ['image_path' => $imagePath]
            );

            $room->images()->syncWithoutDetaching($image->id);

            $this->command->info("Attached image {$imagePath} to room {$room->room_number} (image id: {$image->id})");
        }
    }
}
