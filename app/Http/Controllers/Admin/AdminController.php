<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AI\PromptManager;

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
    public function dashboard(Request $request, \App\Services\DashboardService $dashboardService)
    {
        $range = $request->query('range', '30d');
        
        $data = $dashboardService->getDashboardData($range);
        
        return view('admin.dashboard.index', [
            'stats' => $data['stats'],
            'recentContacts' => $data['recentContacts'],
            'recentTcRequests' => $data['recentTcRequests'],
            'recentBlogs' => $data['recentBlogs'],
            'topBlogs' => $data['topBlogs'],
            'chartData' => $data['chartData'],
            'range' => $data['range']
        ]);
    }

    /**
     * Generate AI Content Insights for the dashboard.
     */
    public function generateInsights(Request $request, \App\Services\AI\AIService $ai)
    {
        // Allow forcing a refresh via ?refresh=1
        $forceRefresh = $request->boolean('refresh');
        
        $cacheKey = 'dashboard_ai_insights';
        
        if ($forceRefresh) {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        $insights = \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addHours(24), function () use ($ai) {
            
            // Gather context data (limited to prevent huge tokens)
            $blogs = \App\Models\Blog::latest()->take(10)->get()->map(function($b) {
                return $b->title . ' - ' . strip_tags($b->excerpt);
            })->implode("\n");
            
            $services = \App\Models\Service::where('is_active', true)->get()->pluck('title')->implode(", ");
            
            $promptArray = PromptManager::renderWithRoles('dashboard_insights', [
                'services' => $services,
                'blogs' => $blogs
            ]);
            $prompt = $promptArray['system'] . "\n\n" . $promptArray['user'];

            try {
                $schema = [
                    'type' => 'OBJECT',
                    'properties' => [
                        'performance_predictions' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],
                        'readability_scores' => [
                            'type' => 'OBJECT',
                            'properties' => [
                                'score' => ['type' => 'STRING'],
                                'notes' => ['type' => 'STRING']
                            ]
                        ],
                        'content_gap_analysis' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],
                        'suggested_calendar' => [
                            'type' => 'ARRAY',
                            'items' => [
                                'type' => 'OBJECT',
                                'properties' => [
                                    'date' => ['type' => 'STRING'],
                                    'topic' => ['type' => 'STRING'],
                                    'type' => ['type' => 'STRING']
                                ]
                            ]
                        ]
                    ],
                    'required' => ['performance_predictions', 'readability_scores', 'content_gap_analysis', 'suggested_calendar']
                ];

                $data = $ai->generateStructured($prompt, $schema, ['temperature' => 0.4]);

                return $data;

            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('AI Dashboard Insights failed: ' . $e->getMessage());
                return [
                    "error" => "Failed to generate insights at this time.",
                ];
            }
        });

        return response()->json($insights);
    }
}