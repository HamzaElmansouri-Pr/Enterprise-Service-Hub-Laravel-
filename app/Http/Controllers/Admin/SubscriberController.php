<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();
        
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }
        
        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber deleted successfully.');
    }

    public function toggleStatus(Subscriber $subscriber)
    {
        $subscriber->is_active = !$subscriber->is_active;
        if (!$subscriber->is_active) {
            $subscriber->unsubscribed_at = now();
        } else {
            $subscriber->unsubscribed_at = null;
        }
        $subscriber->save();
        
        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber status updated.');
    }

    public function export()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->get();
        
        return \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload('subscribers.csv')
            ->addRows($subscribers->map(function ($sub) {
                return [
                    'ID' => $sub->id,
                    'Email' => $sub->email,
                    'Status' => $sub->is_active ? 'Active' : 'Unsubscribed',
                    'Subscribed Date' => $sub->created_at->format('Y-m-d H:i:s'),
                    'Unsubscribed Date' => $sub->unsubscribed_at ? $sub->unsubscribed_at->format('Y-m-d H:i:s') : '',
                ];
            })->toArray())
            ->toBrowser();
    }
}
