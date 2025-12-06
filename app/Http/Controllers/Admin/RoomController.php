<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Room;
use App\Models\Image;
use App\Models\RoomsImage;
use App\Models\RoomFacility; // added
use Illuminate\Support\Facades\Storage;

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
        // load facilities so the create view can render checkboxes
        $facilities = RoomFacility::orderBy('name')->get();
        return view('admin.rooms.create', compact('facilities'));
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
            'images.*'      => ['nullable','image','max:2048'],
            'facilities'    => ['nullable','array'],
            'facilities.*'  => ['integer','exists:room_facilities,id'],
        ]);

        $room = Room::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file->isValid()) {
                    continue;
                }

                // Use content-hash filename so identical uploads reuse the same stored file + DB row
                $contents = file_get_contents($file->getRealPath());
                $hash = sha1($contents);
                $filename = $hash . '.' . $file->getClientOriginalExtension();
                $path = 'rooms/' . $filename;

                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, $contents);
                }

                $image = Image::firstOrCreate(['image_path' => $path]);

                // attach via rooms_images pivot relation (avoid duplicates)
                $room->rooms_images()->firstOrCreate(
                    ['image_id' => $image->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        // persist selected facilities (rooms_facilities pivot)
        if ($request->filled('facilities')) {
            // remove any existing pivot rows (should be none for a fresh room)
            $room->rooms_facilities()->delete();
            foreach ($request->input('facilities', []) as $fid) {
                $room->rooms_facilities()->create(['facility_id' => $fid]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success','Room created.');
    }

    public function show(Room $room): View
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room): View
    {
        // provide all facilities so edit can render checkboxes and mark current ones
        $facilities = RoomFacility::orderBy('name')->get();
        return view('admin.rooms.edit', compact('room','facilities'));
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
            'images.*'      => ['nullable','image','max:2048'],
            'replace_images.*' => ['nullable','image','max:2048'],
            'facilities'    => ['nullable','array'],
            'facilities.*'  => ['integer','exists:room_facilities,id'],
        ]);

        $room->update($data);

        // attach any newly uploaded images (reuse existing files/rows when possible)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file->isValid()) {
                    continue;
                }

                $contents = file_get_contents($file->getRealPath());
                $hash = sha1($contents);
                $filename = $hash . '.' . $file->getClientOriginalExtension();
                $path = 'rooms/' . $filename;

                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, $contents);
                }

                $image = Image::firstOrCreate(['image_path' => $path]);

                $room->rooms_images()->firstOrCreate(['image_id' => $image->id]);
            }
        }

        // handle replacements: replace_images keyed by old image id => uploaded file
        if ($request->hasFile('replace_images')) {
            foreach ($request->file('replace_images') as $oldImageId => $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                // store new file deterministically
                $contents = file_get_contents($file->getRealPath());
                $hash = sha1($contents);
                $filename = $hash . '.' . $file->getClientOriginalExtension();
                $newPath = 'rooms/' . $filename;

                if (!Storage::disk('public')->exists($newPath)) {
                    Storage::disk('public')->put($newPath, $contents);
                }

                // create or reuse image row for new file
                $newImage = Image::firstOrCreate(['image_path' => $newPath]);

                // attach new pivot row
                $room->rooms_images()->firstOrCreate(['image_id' => $newImage->id]);

                // detach old pivot link via pivot rows
                $room->rooms_images()->where('image_id', $oldImageId)->delete();

                // remove old image row + file if no other rooms reference it
                $oldImage = Image::find($oldImageId);
                if ($oldImage && $oldImage->rooms()->count() === 0) {
                    if (Storage::disk('public')->exists($oldImage->image_path)) {
                        Storage::disk('public')->delete($oldImage->image_path);
                    }
                    $oldImage->delete();
                }
            }
        }

        // sync room facilities: delete existing pivot rows and recreate from selection
        $selected = $request->input('facilities', []);
        // remove all existing pivots for this room
        $room->rooms_facilities()->delete();
        foreach ($selected as $fid) {
            $room->rooms_facilities()->create(['facility_id' => $fid]);
        }
        return redirect()->route('admin.rooms.index')->with('success','Room updated.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        // collect images before deleting the room pivot
        $images = $room->rooms_images()->with('image')->get()->pluck('image')->filter();

        // remove pivot links (delete pivot rows)
        $room->rooms_images()->delete();

        // delete the room
        $room->delete();

        // for each image: if no rooms reference it, delete file + DB row
        foreach ($images as $image) {
            if ($image->rooms()->count() === 0) {
                // remove file if exists
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        }

        return redirect()->route('admin.rooms.index')->with('success','Room deleted.');
    }
}