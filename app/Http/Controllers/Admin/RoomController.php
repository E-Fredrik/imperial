<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Room;

class RoomController extends Controller
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

    public function index(): View
    {
        $rooms = Room::orderBy('id','asc')->paginate(15);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'room_number'   => ['required','string','max:191','unique:rooms,room_number'],
            'price'         => ['nullable','numeric','min:0'],
            'length'        => ['nullable','numeric'],
            'width'         => ['nullable','numeric'],
            'type'          => ['nullable','string','max:191'],
            'floor'         => ['nullable','integer'],
            'status'        => ['nullable','in:available,booked,unavailable'],
            'description'   => ['nullable','string'],
        ]);

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success','Room created.');
    }

    public function show(Room $room): View
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room): View
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $data = $request->validate([
            'room_number'   => ['required','string','max:191','unique:rooms,room_number,'.$room->id],
            'price'         => ['nullable','numeric','min:0'],
            'length'        => ['nullable','numeric'],
            'width'         => ['nullable','numeric'],
            'type'          => ['nullable','string','max:191'],
            'floor'         => ['nullable','integer'],
            'status'        => ['nullable','in:available,booked,unavailable'],
            'description'   => ['nullable','string'],
        ]);

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success','Room updated.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success','Room deleted.');
    }
}