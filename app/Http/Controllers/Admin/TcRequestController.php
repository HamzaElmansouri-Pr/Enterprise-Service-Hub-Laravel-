<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TcRequest;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\UpdateTcRequestStatusRequest;

class TcRequestController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', TcRequest::class);
        $query = TcRequest::with('service');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tcRequests = $query->latest()->paginate(10);
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

    public function updateStatus(UpdateTcRequestStatusRequest $request, $id)
    {
        $tcRequest = TcRequest::findOrFail($id);
        $this->authorize('update', $tcRequest);
        
        $validated = $request->validated();

        $tcRequest->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }

    public function inlineUpdate(Request $request, $id)
    {
        $tcRequest = TcRequest::findOrFail($id);
        $this->authorize('update', $tcRequest);

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,contacted,completed,spam'
        ]);

        $tcRequest->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }

    public function bulkAction(Request $request)
    {
        $this->authorize('viewAny', TcRequest::class);

        $validated = $request->validate([
            'action' => 'required|in:delete,mark_read,mark_unread',
            'ids' => 'required|json'
        ]);

        $ids = json_decode($validated['ids'], true);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No items selected.');
        }

        switch ($validated['action']) {
            case 'delete':
                TcRequest::whereIn('id', $ids)->delete();
                $message = 'Selected requests deleted.';
                break;
            case 'mark_read':
                TcRequest::whereIn('id', $ids)->update(['is_read' => true, 'read_at' => now()]);
                $message = 'Selected requests marked as read.';
                break;
            case 'mark_unread':
                TcRequest::whereIn('id', $ids)->update(['is_read' => false, 'read_at' => null]);
                $message = 'Selected requests marked as unread.';
                break;
        }

        return back()->with('success', $message);
    }

    public function export()
    {
        $fileName = 'tcrequests_export_' . now()->format('Y_m_d_His') . '.csv';
        
        return response()->streamDownload(function () {
            $writer = \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload('php://output');
            
            TcRequest::with('service')->chunk(500, function ($tcRequests) use ($writer) {
                foreach ($tcRequests as $request) {
                    $writer->addRow([
                        'ID' => $request->id,
                        'Email' => $request->email,
                        'Service Requested' => $request->service ? $request->service->title : 'N/A',
                        'Description' => $request->description,
                        'Status' => ucfirst($request->status),
                        'Read Status' => $request->is_read ? 'Read' : 'Unread',
                        'Has Attachment' => $request->attached_file ? 'Yes' : 'No',
                        'Submitted At' => $request->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            
            $writer->close();
        }, $fileName, ['Content-Type' => 'text/csv']);
    }
}
