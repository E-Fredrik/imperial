<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\View\View;

class RoomDisplayController extends Controller
{
    public function index(): View
    {
        $rooms = Room::with(['images', 'rooms_facilities.room_facility'])
            ->orderBy('floor')
            ->orderBy('room_number')
            ->get();
        
        return view('room', compact('rooms'));
    }
}
