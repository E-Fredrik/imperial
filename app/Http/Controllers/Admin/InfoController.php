<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InfoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (($request->user()->role ?? '') !== 'admin') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index() : View {
        $info = Information::orderBy("id", "asc")->paginate(15);
        return view('admin.info.index', compact('info'));
    }

    public function create() : View {
        // pass an empty model so the create view can reuse the edit form safely
        return view('admin.info.create', ['information' => new Information()]);
    }

    public function store(Request $request) : RedirectResponse {
        $data = $request->validate([
            'title'   => ['required','string','max:191'],
            'content' => ['nullable', 'string'],
        ]);
        
        Information::create([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
        ]);

        return redirect()->route('admin.info.index')->with('success','Information created.');
    }

    public function show(Information $information) : View {
        return view('admin.info.show', compact('information'));
    }

    // keep parameter name matching route param for clarity, then pass to view as `information`
    public function edit(Information $info) : View {
        return view('admin.info.edit', ['information' => $info]);
    }

    public function update(Request $request, Information $information) : RedirectResponse {
        $data = $request->validate([
            'title'   => ['required','string','max:191'],
            'content' => ['nullable', 'string'],
        ]);

        $information->update([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
        ]);

        return redirect()->route('admin.info.index')->with('success','Information updated.');
    }

    /**
     * Remove the specified information (resource route expects destroy).
     */
    public function destroy(Information $information) : RedirectResponse {
        $information->delete();
        return redirect()->route('admin.info.index')->with('success','Information deleted.');
    }
}
