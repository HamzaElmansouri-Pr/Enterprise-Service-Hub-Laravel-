<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Page;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Contact;
use App\Models\TcRequest;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get aggregated and cached dashboard data.
     */
    public function getDashboardData(string $range): array
    {
        return Cache::remember('admin_dashboard_' . $range, now()->addMinutes(5), function () use ($range) {
            $days = match ($range) {
                '7d' => 7,
                '90d' => 90,
                '1y' => 365,
                default => 30,
            };

            $startDate = now()->subDays($days - 1)->startOfDay();
            $endDate = now()->endOfDay();

            // Stats could be consolidated into one query if using raw SQL,
            // but caching for 5 minutes already solves the I/O bottleneck.
            $stats = [
                'total_users' => User::count(),
                'total_pages' => Page::count(),
                'total_services' => Service::count(),
                'total_projects' => Project::count(),
                'total_blogs' => Blog::count(),
                'total_reviews' => Review::count(),
                'total_contacts' => Contact::count(),
                'total_tc_requests' => TcRequest::count(),
                'unread_contacts' => Contact::where('is_read', false)->count(),
                'unread_tc_requests' => TcRequest::where('is_read', false)->count(),
                'pending_tc_requests' => TcRequest::where('status', 'pending')->count(),
                'published_blogs' => Blog::whereNotNull('published_at')->count(),
                'featured_projects' => Project::where('is_featured', true)->count(),
                'active_services' => Service::where('is_active', true)->count(),
            ];

            // Recent activities
            $recentContacts = Contact::latest()->take(5)->get();
            $recentTcRequests = TcRequest::with('service')->latest()->take(5)->get();
            $recentBlogs = Blog::latest()->take(5)->get();

            // Top Performing Blogs
            $topBlogs = Blog::withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->take(5)
                ->get();

            // Chart Data
            $chartData = $this->generateChartData($startDate, $endDate, $days, $range);

            return [
                'stats' => $stats,
                'recentContacts' => $recentContacts,
                'recentTcRequests' => $recentTcRequests,
                'recentBlogs' => $recentBlogs,
                'topBlogs' => $topBlogs,
                'chartData' => $chartData,
                'range' => $range
            ];
        });
    }

    private function generateChartData(Carbon $startDate, Carbon $endDate, int $days, string $range): array
    {
        $contactsData = Contact::selectRaw('DATE(created_at) as date, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        $tcRequestsData = TcRequest::selectRaw('DATE(created_at) as date, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        $blogsData = Blog::selectRaw('DATE(published_at) as date, count(*) as count')
            ->whereNotNull('published_at')
            ->whereBetween('published_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        $chartDates = [];
        $contactsSeries = [];
        $tcRequestsSeries = [];
        $blogsSeries = [];

        if ($days === 365) {
            $yearStart = now()->subMonths(11)->startOfMonth();

            $contactsMonthly = Contact::selectRaw("to_char(created_at, 'YYYY-MM') as month, count(*) as count")
                ->where('created_at', '>=', $yearStart)
                ->groupBy('month')
                ->pluck('count', 'month');

            $tcRequestsMonthly = TcRequest::selectRaw("to_char(created_at, 'YYYY-MM') as month, count(*) as count")
                ->where('created_at', '>=', $yearStart)
                ->groupBy('month')
                ->pluck('count', 'month');

            $blogsMonthly = Blog::selectRaw("to_char(published_at, 'YYYY-MM') as month, count(*) as count")
                ->whereNotNull('published_at')
                ->where('published_at', '>=', $yearStart)
                ->groupBy('month')
                ->pluck('count', 'month');

            for ($i = 11; $i >= 0; $i--) {
                $monthDate = now()->subMonths($i);
                $key = $monthDate->format('Y-m');
                $chartDates[] = $monthDate->format('M Y');
                
                $contactsSeries[] = $contactsMonthly->get($key, 0);
                $tcRequestsSeries[] = $tcRequestsMonthly->get($key, 0);
                $blogsSeries[] = $blogsMonthly->get($key, 0);
            }
        } else {
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $chartDates[] = now()->subDays($i)->format('M d');
                $contactsSeries[] = $contactsData->get($date, 0);
                $tcRequestsSeries[] = $tcRequestsData->get($date, 0);
                $blogsSeries[] = $blogsData->get($date, 0);
            }
        }

        $distributionData = [
            'contacts' => Contact::whereBetween('created_at', [$startDate, $endDate])->count(),
            'tc_requests' => TcRequest::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        return [
            'labels' => $chartDates,
            'contacts' => $contactsSeries,
            'tcRequests' => $tcRequestsSeries,
            'blogs' => $blogsSeries,
            'distribution' => $distributionData,
            'range' => $range
        ];
    }
}
