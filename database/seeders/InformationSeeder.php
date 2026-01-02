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
        Information::create([
            'title' => 'Description',
            'content'=> 'Live like a king, Feel like home'
        ]);
        Information::create([
            'title' => 'Title',
            'content'=> 'Imperial Kost'
        ]);
        Information::create([
            'title' => 'Phone',
            'content' => '+6282139721494'
        ]);
        Information::create([
            'title' => 'Whatsapp',
            'content' => '+628385675857'
        ]);
        Information::create([
            'title' => 'Email',
            'content' => 'test@imperial.com'
        ]);

    }
}
