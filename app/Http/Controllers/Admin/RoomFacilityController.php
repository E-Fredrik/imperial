<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\RoomFacility;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.roomfac.index', compact('facilities'));
    }

    public function create() : View {
        return view('admin.roomfac.create');
    }

    public function store(Request $request) : RedirectResponse {
        $data = $request->validate([
            'name'   => ['required','string','max:191','unique:room_facilities,name'],
            'description' => ['nullable', 'string'],
        ]);

        RoomFacility::create($data);

        return redirect()->route('admin.roomfac.index')->with('success','Room Facility created.');
    }

    public function show(RoomFacility $roomfac) : View {
        return view('admin.roomfac.show', compact('roomfac'));
    }

    public function edit(RoomFacility $roomfac) : View {
        return view('admin.roomfac.edit', compact('roomfac'));
    }

    public function update(Request $request, RoomFacility $roomfac) : RedirectResponse {
        $data = $request->validate([
            'name'   => ['required','string','max:191','unique:room_facilities,name,'.$roomfac->id],
            'description' => ['nullable', 'string'],
        ]);

        $roomfac->update($data);
        return redirect()->route('admin.roomfac.index')->with('success','Room Facility updated.');
    }

    public function destroy(RoomFacility $roomfac) : RedirectResponse {
        $roomfac->delete();
        return redirect()->route('admin.roomfac.index')->with('success', 'Room Facility deleted.');
    }
}
