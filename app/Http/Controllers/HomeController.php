<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Room;

class HomeController extends Controller
{
    public function index() {
        // Get featured images
        $featured = Image::where('is_featured', true)
            ->orderByDesc('created_at')
            ->get();

        // Get ALL rooms with relationships
        $rooms = Room::with([
            'images', 
            'rooms_facilities.room_facility'
        ])
        ->orderBy('room_number')
        ->get();

        return view('home', compact('featured', 'rooms'));
    }
}
