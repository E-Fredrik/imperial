<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Room;

class HomeController extends Controller
{
    public function index() {
        $featured = Image::where('is_featured', true)
            ->orderByDesc('created_at')
            ->get();

        $rooms = Room::where('status', 'available')
            ->with('images')
            ->orderBy('room_number')
            ->get();

        return view('home', compact('featured', 'rooms'));
    }
}
