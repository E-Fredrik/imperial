<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Image;
use App\Models\Information;
use App\Models\KostFacility;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get all rooms with their images
        $rooms = Room::with('images')->where('status', 'available')->get();

        // Get featured images for hero carousel
        $featured = Image::where('is_featured', true)->get();

        // Get all information (including Terms and Rules)
        $information = Information::all();

        // Get kost facilities with their images
        $kostFacilities = KostFacility::with('facilities_images.image')->get();

        return view('home', compact('rooms', 'featured', 'information', 'kostFacilities'));
    }
}
