<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\KostFacility;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class KostFacilityController extends Controller
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
        $facilities = KostFacility::orderBy('id', 'asc')->paginate(15);
        return view('admin.kostfac.index', compact('facilities'));
    }

    public function create(): View
    {
        // pass empty model so create view can reuse edit markup
        return view('admin.kostfac.create', ['kostfac' => new KostFacility()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:kost_facilities,name'],
            'description' => ['nullable','string'],
            'images.*' => ['nullable','image','max:2048'],
        ]);

        $kostfac = KostFacility::create($data);

        // attach uploaded images (store on storage/app/public/kostfac)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (! $file->isValid()) continue;

                $contents = file_get_contents($file->getRealPath());
                $hash = sha1($contents);
                $filename = $hash . '.' . $file->getClientOriginalExtension();
                $path = 'kostfac/' . $filename;

                if (! Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, $contents);
                }

                $image = Image::firstOrCreate(['image_path' => $path]);

                // create pivot row via relation so facility_id is set correctly
                $kostfac->facilities_images()->firstOrCreate(['image_id' => $image->id]);
            }
        }

        return redirect()->route('admin.kostfac.index')->with('success', 'Kost Facility created.');
    }

    public function show(KostFacility $kostfac): View
    {
        return view('admin.kostfac.show', compact('kostfac'));
    }

    public function edit(KostFacility $kostfac): View
    {
        return view('admin.kostfac.edit', compact('kostfac'));
    }

    public function update(Request $request, KostFacility $kostfac): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:kost_facilities,name,'.$kostfac->id],
            'description' => ['nullable','string'],
            'images.*' => ['nullable','image','max:2048'],
            'replace_images.*' => ['nullable','image','max:2048'],
        ]);

        $kostfac->update($data);

        // attach newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (! $file || ! $file->isValid()) continue;

                $contents = file_get_contents($file->getRealPath());
                $hash = sha1($contents);
                $filename = $hash . '.' . $file->getClientOriginalExtension();
                $path = 'kostfac/' . $filename;

                if (! Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, $contents);
                }

                $image = Image::firstOrCreate(['image_path' => $path]);

                $kostfac->facilities_images()->firstOrCreate(['image_id' => $image->id]);
            }
        }

        // handle replacements: replace_images keyed by old image id => uploaded file
        if ($request->hasFile('replace_images')) {
            foreach ($request->file('replace_images') as $oldImageId => $file) {
                if (! $file || ! $file->isValid()) {
                    continue;
                }

                // store new file deterministically
                $contents = file_get_contents($file->getRealPath());
                $hash = sha1($contents);
                $filename = $hash . '.' . $file->getClientOriginalExtension();
                $newPath = 'kostfac/' . $filename;

                if (! Storage::disk('public')->exists($newPath)) {
                    Storage::disk('public')->put($newPath, $contents);
                }

                // create or reuse image row for new file
                $newImage = Image::firstOrCreate(['image_path' => $newPath]);

                // attach new pivot row for this facility (if not already attached)
                $kostfac->facilities_images()->firstOrCreate(['image_id' => $newImage->id]);

                // detach old pivot link(s) for this facility -> old image
                $kostfac->facilities_images()->where('image_id', $oldImageId)->delete();

                // cleanup old image if unreferenced anywhere
                $oldImage = Image::find($oldImageId);
                if ($oldImage && $oldImage->rooms()->count() === 0 && $oldImage->facilities_images()->count() === 0) {
                    if (Storage::disk('public')->exists($oldImage->image_path)) {
                        Storage::disk('public')->delete($oldImage->image_path);
                    }
                    $oldImage->delete();
                }
            }
        }

        return redirect()->route('admin.kostfac.index')->with('success', 'Kost Facility updated.');
    }

    public function destroy(KostFacility $kostfac): RedirectResponse
    {
        // collect images before deleting pivots
        $images = $kostfac->facilities_images()->with('image')->get()->pluck('image')->filter();

        // delete pivot rows for this facility
        $kostfac->facilities_images()->delete();

        // delete facility
        $kostfac->delete();

        // cleanup images not referenced elsewhere
        foreach ($images as $image) {
            if ($image->rooms()->count() === 0 && $image->facilities_images()->count() === 0) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        }

        return redirect()->route('admin.kostfac.index')->with('success', 'Kost Facility deleted.');
    }
}