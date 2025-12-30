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
        }

        // add 360 image and attach to room A (ensure is_360 = true)
        $url360 = 'https://momento360.com/e/u/913703badaaa4dbfbf3926e70de201cb?utm_campaign=embed&utm_source=other&heading=0&pitch=0&field-of-view=75&size=medium&display-plan=true';
        $image360 = Image::updateOrCreate(
            ['image_path' => $url360],
            ['description' => null, 'is_360' => true]
        );

        $roomA = Room::where('room_number', 'A')->first();
        if ($roomA) {
            $roomA->images()->syncWithoutDetaching($image360->id);
        }
    }
}
