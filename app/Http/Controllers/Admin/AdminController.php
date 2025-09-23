<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }
    
    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
    
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_pages' => \App\Models\Page::count(),
            'total_services' => \App\Models\Service::count(),
            'total_projects' => \App\Models\Project::count(),
            'total_blogs' => \App\Models\Blog::count(),
            'total_reviews' => \App\Models\Review::count(),
            'total_sliders' => \App\Models\Slider::count(),
            'total_contacts' => \App\Models\Contact::count(),
            'total_tc_requests' => \App\Models\TcRequest::count(),
            'unread_contacts' => \App\Models\Contact::where('is_read', false)->count(),
            'unread_tc_requests' => \App\Models\TcRequest::where('is_read', false)->count(),
            'pending_tc_requests' => \App\Models\TcRequest::where('status', 'pending')->count(),
            'published_blogs' => \App\Models\Blog::where('is_published', true)->count(),
            'featured_projects' => \App\Models\Project::where('is_featured', true)->count(),
            'active_services' => \App\Models\Service::where('is_active', true)->count(),
        ];
        
        // Recent activities
        $recentContacts = \App\Models\Contact::latest()->take(5)->get();
        $recentTcRequests = \App\Models\TcRequest::with('service')->latest()->take(5)->get();
        $recentBlogs = \App\Models\Blog::latest()->take(5)->get();
        
        return view('admin.dashboard.index', compact('stats', 'recentContacts', 'recentTcRequests', 'recentBlogs'));
    }
}