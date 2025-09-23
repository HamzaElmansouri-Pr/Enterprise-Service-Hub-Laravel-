<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        // Mark as read
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function markAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Contact marked as read.');
    }

    public function markAsUnread(Contact $contact)
    {
        $contact->update(['is_read' => false]);
        
        return redirect()->back()->with('success', 'Contact marked as unread.');
    }

    public function markAllAsRead()
    {
        Contact::where('is_read', false)->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'All contacts marked as read.');
    }

    public function bulkDelete(Request $request)
    {
        $contactIds = $request->input('contact_ids', []);
        
        if (empty($contactIds)) {
            return redirect()->back()->with('error', 'No contacts selected for deletion.');
        }

        Contact::whereIn('id', $contactIds)->delete();
        
        return redirect()->back()->with('success', 'Selected contacts deleted successfully.');
    }
}