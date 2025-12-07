<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class HomeController extends Controller
{
    public function index() {
        $featured = Image::where('is_featured', true)
            ->orderByDesc('created_at')
            ->get();

        return view('home', compact('featured'));
    }
}
