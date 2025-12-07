<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
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

    // list all uploaded images (public files + storage)
    public function index(): View
    {
        $images = Image::orderByDesc('created_at')->paginate(36);
        return view('admin.images.index', compact('images'));
    }

    // upload form
    public function create(): View
    {
        return view('admin.images.create');
    }

    // store uploaded image file + DB row
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['required','image','max:8192'],
            'description' => ['nullable','string'],
            'is_featured' => ['nullable','boolean'],
        ]);

        $file = $request->file('image');
        $contents = file_get_contents($file->getRealPath());
        $hash = sha1($contents . Str::random(6));
        $filename = $hash . '.' . $file->getClientOriginalExtension();
        $path = 'images/' . $filename;

        Storage::disk('public')->put($path, $contents);

        Image::create([
            'image_path' => $path,
            'description' => $data['description'] ?? null,
            'is_featured' => $request->boolean('is_featured', false),
        ]);

        return redirect()->route('admin.images.index')->with('success','Image uploaded.');
    }

    // toggle featured on/off
    public function toggleFeatured(Image $image): RedirectResponse
    {
        $image->is_featured = ! (bool) $image->is_featured;
        $image->save();

        return redirect()->back()->with('success', 'Image featured status updated.');
    }

    // delete image + file
    public function destroy(Image $image): RedirectResponse
    {
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return redirect()->route('admin.images.index')->with('success','Image deleted.');
    }
}
