<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrashController extends Controller
{
    /**
     * Map of available models for trash view.
     */
    protected $models = [
        'services' => \App\Models\Service::class,
        'projects' => \App\Models\Project::class,
        'blogs' => \App\Models\Blog::class,
        'contacts' => \App\Models\Contact::class,
        'tc-requests' => \App\Models\TcRequest::class,
        'reviews' => \App\Models\Review::class,
        'sliders' => \App\Models\Slider::class,
    ];

    public function index(Request $request)
    {
        $type = $request->get('type', 'services');

        if (!array_key_exists($type, $this->models)) {
            abort(404, 'Invalid trash type.');
        }

        $modelClass = $this->models[$type];
        
        // Fetch only trashed items
        $items = $modelClass::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(15);
        $items->appends(['type' => $type]);

        return view('admin.trash.index', compact('items', 'type'));
    }

    public function restore($type, $id)
    {
        if (!array_key_exists($type, $this->models)) {
            abort(404, 'Invalid trash type.');
        }

        $modelClass = $this->models[$type];
        $item = $modelClass::onlyTrashed()->findOrFail($id);
        
        $item->restore();

        return redirect()->back()->with('success', ucfirst(Str::singular($type)) . ' restored successfully.');
    }

    public function forceDelete($type, $id)
    {
        if (!array_key_exists($type, $this->models)) {
            abort(404, 'Invalid trash type.');
        }

        $modelClass = $this->models[$type];
        $item = $modelClass::onlyTrashed()->findOrFail($id);
        
        // Let's ensure any file cleanup happens here if needed. 
        // For simplicity, we just force delete the record.
        $item->forceDelete();

        return redirect()->back()->with('success', ucfirst(Str::singular($type)) . ' permanently deleted.');
    }
}
