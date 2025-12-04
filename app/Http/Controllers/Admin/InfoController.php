<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tonysm\RichTextLaravel\Models\RichText;

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

        // Debug: log incoming payload
        Log::info('InfoController@store payload', $request->only('title','content'));

        // create then explicitly save rich text so HasRichText trait runs correctly
        $information = Information::create([
            'title' => $data['title'],
        ]);

        if (method_exists($information, 'setRichText')) {
            // Tonysm API: set rich text field
            $information->setRichText('content', $data['content'] ?? '');
        } else {
            $information->content = $data['content'] ?? '';
        }
        $information->save();

        return redirect()->route('admin.info.index')->with('success','Information created.');
    }

    public function show(Information $information) : View {
        return view('admin.info.show', compact('information'));
    }

    // keep parameter name matching route param for clarity, then pass to view as `information`
    public function edit(Information $info) : View {
        return view('admin.info.edit', ['information' => $info]);
    }

    // Ensure the parameter name matches the route param `{info}` so route-model binding works.
    public function update(Request $request, Information $info) : RedirectResponse {
        $data = $request->validate([
            'title'   => ['required','string','max:191'],
            'content' => ['nullable', 'string'],
        ]);

        // Debug: log incoming payload
        Log::info('InfoController@update payload', $request->only('title','content'));

        // Persist on the bound model ($info) so we update instead of creating.
        $info->title = $data['title'];
        if (method_exists($info, 'setRichText')) {
            // Tonysm: store rich text via API
            $info->setRichText('content', $data['content'] ?? '');
        } else {
            $info->content = $data['content'] ?? '';
        }
        $info->save();

        return redirect()->route('admin.info.index')->with('success','Information updated.');
    }

    /**
     * Remove the specified information (resource route expects destroy).
     */
    public function destroy(Information $information) : RedirectResponse
    {
        $id = $information->getKey();
        Log::info("InfoController@destroy called for id={$id}");

        try {
            DB::transaction(function () use ($information, $id) {
                // Delete related rich_texts using the Tonysm RichText Eloquent model (ORM)
                if (class_exists(RichText::class) && Schema::hasTable('rich_texts')) {
                    RichText::query()
                        ->where('record_type', Information::class)
                        ->where('record_id', $id)
                        ->where('field', 'content')
                        ->delete();
                }

                // Use Eloquent to remove the Information (forceDelete if SoftDeletes used)
                if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($information))) {
                    $information->forceDelete();
                } else {
                    $information->delete();
                }
            });

            Log::info("InfoController@destroy succeeded for id={$id}");
            return redirect()->route('admin.info.index')->with('success', 'Information deleted successfully.');
        } catch (\Throwable $e) {
            Log::error("InfoController@destroy failed for id={$id}: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete information. See logs for details.');
        }
    }
    
    public function destroyById($id) : RedirectResponse
    {
        $info = Information::find($id);
        if (! $info) {
            Log::warning("InfoController@destroyById: information id={$id} not found");
            return back()->with('error', 'Information not found.');
        }

        try {
            DB::beginTransaction();

            if (Schema::hasTable('rich_texts')) {
                // Support common column name variants and ensure we delete only the 'content' field row
                $variants = [
                    ['record_type', 'record_id'],
                    ['owner_type', 'owner_id'],
                ];

                foreach ($variants as [$typeCol, $idCol]) {
                    if (Schema::hasColumn('rich_texts', $typeCol) && Schema::hasColumn('rich_texts', $idCol)) {
                        DB::table('rich_texts')
                            ->where($typeCol, Information::class)
                            ->where($idCol, $id)
                            ->where('field', 'content')
                            ->delete();

                        // Also try short class name if stored differently
                        DB::table('rich_texts')
                            ->where($typeCol, (new \ReflectionClass(Information::class))->getShortName())
                            ->where($idCol, $id)
                            ->where('field', 'content')
                            ->delete();
                    }
                }
            }

            // delete model (force if SoftDeletes used)
            if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($info))) {
                $info->forceDelete();
            } else {
                $info->delete();
            }

            // Safety raw delete to ensure removal
            DB::table('informations')->where('id', $id)->delete();

            DB::commit();
            Log::info("InfoController@destroyById succeeded for id={$id}");
            return redirect()->route('admin.info.index')->with('success', 'Information deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("InfoController@destroyById failed for id={$id}: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete information. See logs.');
        }
    }
}
