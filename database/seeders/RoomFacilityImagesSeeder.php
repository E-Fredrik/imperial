<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Image;
use App\Models\RoomFacility;

class RoomFacilityImagesSeeder extends Seeder
{
    use WithoutModelEvents;

    protected function normalize(string $s): string
    {
        return preg_replace('/[^a-z0-9]/', '', mb_strtolower($s));
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dir = public_path('images/roomFac');

        if (! File::exists($dir) || ! File::isDirectory($dir)) {
            $this->command->warn("Directory not found: {$dir}. Skipping room facility images seeding.");
            return;
        }

        $files = File::files($dir);
        if (empty($files)) {
            $this->command->warn("No files found in {$dir}. Skipping room facility images seeding.");
            return;
        }

        $facilities = RoomFacility::all()->keyBy(function (RoomFacility $f) {
            return $this->normalize($f->name);
        });

        $filesMap = [];
        foreach ($files as $file) {
            $base = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $filesMap[$this->normalize($base)] = $file;
        }

        // explicit mapping: filename -> facility name
        $explicit = [
            'toilet' => 'Kamar Mandi Dalam',
            'waterheater' => 'Water Heater',
            'water-heater' => 'Water Heater',
            'water_heater' => 'Water Heater',
        ];

        $processed = [];

        foreach ($explicit as $fileKey => $facilityName) {
            if (! isset($filesMap[$fileKey])) {
                continue;
            }

            $file = $filesMap[$fileKey];
            $filename = $file->getFilename();
            $relPath = 'images/roomFac/' . $filename;

            $image = Image::firstOrCreate(
                ['image_path' => $relPath],
                ['description' => null]
            );

            $normTarget = $this->normalize($facilityName);
            if ($facilities->has($normTarget)) {
                $facility = $facilities->get($normTarget);

                // prefer model relation if available
                if (method_exists($facility, 'images')) {
                    try {
                        $facility->images()->syncWithoutDetaching($image->id);
                        $this->command->info("Attached {$relPath} -> facility {$facility->name}");
                        $processed[] = $filename;
                        continue;
                    } catch (\Throwable $e) {
                        // fallthrough to direct pivot insert
                    }
                }

                // ensure pivot table exists before using it directly
                $hasFacilitiesImagesTable = Schema::hasTable('facilities_images');
                if ($hasFacilitiesImagesTable) {
                    DB::table('facilities_images')->insertOrIgnore([
                        'facility_id' => $facility->id,
                        'image_id' => $image->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $this->command->info("Attached {$relPath} -> facility {$facility->name} (direct pivot)");
                    $processed[] = $filename;
                    continue;
                }

                // fallback: created image but no pivot available
                $this->command->warn("Created image {$relPath} but couldn't attach to facility {$facility->name} (relation/pivot missing).");
                $processed[] = $filename;
                continue;
            }

            $this->command->info("Created image {$relPath} (no matching facility found).");
        }

        // handle remaining unprocessed files (not in explicit mapping)
        foreach (array_diff(array_keys($filesMap), $processed) as $fileKey) {
            $file = $filesMap[$fileKey];
            $filename = $file->getFilename();
            $relPath = 'images/roomFac/' . $filename;

            $image = Image::firstOrCreate(
                ['image_path' => $relPath],
                ['description' => null]
            );

            $base = pathinfo($filename, PATHINFO_FILENAME);
            $normBase = $this->normalize($base);

            if ($facilities->has($normBase)) {
                $facility = $facilities->get($normBase);

                // prefer model relation if available
                if (method_exists($facility, 'images')) {
                    try {
                        $facility->images()->syncWithoutDetaching($image->id);
                        $this->command->info("Attached {$relPath} -> facility {$facility->name}");
                        continue;
                    } catch (\Throwable $e) {
                        // fallthrough to direct pivot insert
                    }
                }

                if ($hasFacilitiesImagesTable) {
                    DB::table('facilities_images')->insertOrIgnore([
                        'facility_id' => $facility->id,
                        'image_id' => $image->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $this->command->info("Attached {$relPath} -> facility {$facility->name} (direct pivot)");
                    continue;
                }

                // fallback: created image but no pivot available
                $this->command->warn("Created image {$relPath} but couldn't attach to facility {$facility->name} (relation/pivot missing).");
                continue;
            }

            $this->command->info("Created image {$relPath} (no matching facility found).");
        }
    }
}
