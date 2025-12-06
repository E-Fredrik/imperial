<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Information;

class InformationSeeder extends Seeder
{

    public function run(): void
    {
        Information::create([
            'title' => 'Terms & Conditions',
            'content' => 'This is a sample information record.',
        ]);

        Information::create([
            'title' => 'Rules',
            'content' => 'This is another sample information record.',
        ]);
    }
}
