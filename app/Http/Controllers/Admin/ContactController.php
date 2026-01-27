<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // $this->authorize('viewAny', Contact::class);
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        // $this->authorize('view', $contact);
        
        if (!$contact->is_read) {
            $contact->update(['is_read' => true, 'read_at' => now()]);
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        // $this->authorize('delete', $contact);
        
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function markAsRead(Contact $contact)
    {
        // $this->authorize('update', $contact);
        
        $contact->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'Contact marked as read.');
    }

    public function markAsUnread(Contact $contact)
    {
        // $this->authorize('update', $contact);
        
        $contact->update(['is_read' => false, 'read_at' => null]);
        return redirect()->back()->with('success', 'Contact marked as unread.');
    }

    public function markAllAsRead()
    {
        // $this->authorize('viewAny', Contact::class);
        
        Contact::where('is_read', false)->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'All messages marked as read.');
    }
}
