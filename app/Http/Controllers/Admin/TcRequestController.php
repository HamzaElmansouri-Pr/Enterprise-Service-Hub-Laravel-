<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TcRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TcRequestController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', TcRequest::class);
        $tcRequests = TcRequest::with('service')->latest()->paginate(10);
        return view('admin.tc-requests.index', compact('tcRequests'));
    }

    public function show($id)
    {
        $tcRequest = TcRequest::with('service')->findOrFail($id);
        $this->authorize('view', $tcRequest);
        
        if (!$tcRequest->is_read) {
            $tcRequest->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
        return view('admin.tc-requests.show', compact('tcRequest'));
    }

    public function destroy($id)
    {
        $tcRequest = TcRequest::findOrFail($id);
        $this->authorize('delete', $tcRequest);
        
        $tcRequest->delete();

        return redirect()->route('admin.tc-requests.index')
            ->with('success', 'Service request deleted successfully.');
    }

    public function markAllAsRead()
    {
        $this->authorize('viewAny', TcRequest::class);
        
        TcRequest::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'All service requests marked as read.');
    }

    public function markAsRead($id)
    {
        $tcRequest = TcRequest::findOrFail($id);
        $this->authorize('update', $tcRequest);
        
        $tcRequest->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Service request marked as read.');
    }

    public function markAsUnread($id)
    {
        $tcRequest = TcRequest::findOrFail($id);
        $this->authorize('update', $tcRequest);
        
        $tcRequest->update([
            'is_read' => false,
            'read_at' => null,
        ]);
        
        return redirect()->back()->with('success', 'Service request marked as unread.');
    }

    public function updateStatus(Request $request, $id)
    {
        $tcRequest = TcRequest::findOrFail($id);
        $this->authorize('update', $tcRequest);
        
        $request->validate([
            'status' => 'required|in:pending,reviewed,contacted,completed,rejected'
        ]);

        $tcRequest->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }
}
