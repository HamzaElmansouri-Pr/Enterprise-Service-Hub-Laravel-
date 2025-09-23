<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TcRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class TcRequestController extends Controller
{
    public function index()
    {
        $tcRequests = TcRequest::with('service')->latest()->paginate(15);
        return view('admin.tc-requests.index', compact('tcRequests'));
    }

    public function show(TcRequest $tcRequest)
    {
        // Mark as read
        if (!$tcRequest->is_read) {
            $tcRequest->update(['is_read' => true]);
        }
        
        return view('admin.tc-requests.show', compact('tcRequest'));
    }

    public function destroy(TcRequest $tcRequest)
    {
        // Delete attached file if exists
        if ($tcRequest->attached_file && file_exists(storage_path('app/public/' . $tcRequest->attached_file))) {
            unlink(storage_path('app/public/' . $tcRequest->attached_file));
        }

        $tcRequest->delete();

        return redirect()->route('admin.tc-requests.index')
            ->with('success', 'Service request deleted successfully.');
    }

    public function markAsRead(TcRequest $tcRequest)
    {
        $tcRequest->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Service request marked as read.');
    }

    public function markAsUnread(TcRequest $tcRequest)
    {
        $tcRequest->update(['is_read' => false]);
        
        return redirect()->back()->with('success', 'Service request marked as unread.');
    }

    public function markAllAsRead()
    {
        TcRequest::where('is_read', false)->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'All service requests marked as read.');
    }

    public function bulkDelete(Request $request)
    {
        $tcRequestIds = $request->input('tc_request_ids', []);
        
        if (empty($tcRequestIds)) {
            return redirect()->back()->with('error', 'No service requests selected for deletion.');
        }

        $tcRequests = TcRequest::whereIn('id', $tcRequestIds)->get();
        
        // Delete attached files
        foreach ($tcRequests as $tcRequest) {
            if ($tcRequest->attached_file && file_exists(storage_path('app/public/' . $tcRequest->attached_file))) {
                unlink(storage_path('app/public/' . $tcRequest->attached_file));
            }
        }

        TcRequest::whereIn('id', $tcRequestIds)->delete();
        
        return redirect()->back()->with('success', 'Selected service requests deleted successfully.');
    }

    public function downloadFile(TcRequest $tcRequest)
    {
        if (!$tcRequest->attached_file || !file_exists(storage_path('app/public/' . $tcRequest->attached_file))) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $tcRequest->attached_file));
    }
}