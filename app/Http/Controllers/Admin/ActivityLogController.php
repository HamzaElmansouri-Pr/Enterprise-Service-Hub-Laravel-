<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with(['causer', 'subject'])->latest();

        // Filter by causer
        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        // Filter by entity type
        if ($request->filled('subject_type')) {
            $query->where('subject_type', 'like', '%' . $request->subject_type . '%');
        }

        // Filter by action
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->paginate(30)->withQueryString();

        // Get unique entity types and actions for dropdowns
        $entityTypes = ActivityLog::select('subject_type')->distinct()->whereNotNull('subject_type')->pluck('subject_type')->mapWithKeys(function ($type) {
            return [$type => class_basename($type)];
        });
        
        $actions = ActivityLog::select('log_name')->distinct()->whereNotNull('log_name')->pluck('log_name');
        $users = User::pluck('name', 'id');

        return view('admin.activity-logs.index', compact('logs', 'entityTypes', 'actions', 'users'));
    }

    /**
     * Export activity logs to CSV.
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with(['causer', 'subject'])->latest();

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }
        if ($request->filled('subject_type')) {
            $query->where('subject_type', 'like', '%' . $request->subject_type . '%');
        }
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->get();

        $filename = 'activity_logs_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID', 'Date', 'User ID', 'User Name', 'Action', 'Description', 
                'Entity Type', 'Entity ID', 'Properties'
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->causer_id ?? 'System',
                    $log->causer ? $log->causer->name : 'System',
                    $log->log_name,
                    $log->description,
                    $log->subject_type ? class_basename($log->subject_type) : '',
                    $log->subject_id,
                    json_encode($log->properties)
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
