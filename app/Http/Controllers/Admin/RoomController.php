<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Room;
use App\Models\Image;
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
            'images.*'      => ['nullable','image','max:2048'],
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

                // store only if the file doesn't already exist on disk
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, $contents);
                }

                // reuse existing Image row if present, otherwise create
                $image = Image::firstOrCreate(['image_path' => $path]);

                // attach via pivot, avoid duplicates
                $room->images()->syncWithoutDetaching($image->id);
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
            'images.*'      => ['nullable','image','max:2048'],
            'replace_images.*' => ['nullable','image','max:2048'],
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

                $room->images()->syncWithoutDetaching($image->id);
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

                // attach new image to room if not already attached
                $room->images()->syncWithoutDetaching($newImage->id);

                // detach old pivot link
                $room->images()->detach($oldImageId);

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

        return redirect()->route('admin.rooms.index')->with('success','Room updated.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        // collect images before deleting the room pivot
        $images = $room->images()->get();

        // remove pivot links
        $room->images()->detach();

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