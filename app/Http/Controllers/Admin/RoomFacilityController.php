<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\RoomFacility;

class RoomFacilityController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (($request->user()->role ?? '') !== 'admin') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index() : View {
        $facilities = RoomFacility::orderBy('id','asc') -> paginate(15);
        return view('admin.roomfac.index', compact('facilities'))
    }

    
}
