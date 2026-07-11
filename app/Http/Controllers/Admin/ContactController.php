<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Contact::class);
        
        $query = Contact::query();

        // Advanced Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
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

        $contacts = $query->latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        
        if (!$contact->is_read) {
            $contact->markAsRead();
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
        
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function markAsRead(Contact $contact)
    {
        $this->authorize('update', $contact);
        
        $contact->markAsRead();
        return redirect()->back()->with('success', 'Contact marked as read.');
    }

    public function markAsUnread(Contact $contact)
    {
        $this->authorize('update', $contact);
        
        $contact->markAsUnread();
        return redirect()->back()->with('success', 'Contact marked as unread.');
    }

    public function markAllAsRead()
    {
        $this->authorize('viewAny', Contact::class);
        
        Contact::where('is_read', false)->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'All messages marked as read.');
    }

    public function bulkAction(Request $request)
    {
        $this->authorize('viewAny', Contact::class);

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
                Contact::whereIn('id', $ids)->delete();
                $message = 'Selected contacts deleted.';
                break;
            case 'mark_read':
                Contact::whereIn('id', $ids)->update(['is_read' => true, 'read_at' => now()]);
                $message = 'Selected contacts marked as read.';
                break;
            case 'mark_unread':
                Contact::whereIn('id', $ids)->update(['is_read' => false, 'read_at' => null]);
                $message = 'Selected contacts marked as unread.';
                break;
        }

        return back()->with('success', $message);
    }

    public function export()
    {
        $this->authorize('viewAny', Contact::class);

        $fileName = 'contacts_export_' . now()->format('Y_m_d_His') . '.csv';
        
        return response()->streamDownload(function () {
            $writer = \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload('php://output');
            
            Contact::chunk(500, function ($contacts) use ($writer) {
                foreach ($contacts as $contact) {
                    $writer->addRow([
                        'ID' => $contact->id,
                        'Name' => $contact->name,
                        'Email' => $contact->email,
                        'Phone' => $contact->phone,
                        'Subject' => $contact->subject,
                        'Message' => $contact->message,
                        'Status' => $contact->is_read ? 'Read' : 'Unread',
                        'Submitted At' => $contact->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            
            $writer->close();
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    public function reply(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($contact->email)->send(
                new \App\Mail\ContactReply($contact, $request->reply_message)
            );

            $contact->markAsReplied();

            return redirect()->back()->with('success', 'Reply sent successfully to ' . $contact->email);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send contact reply: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send reply. Please check mail configuration.');
        }
    }
}
