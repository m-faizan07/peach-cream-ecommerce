<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfThisWeek = $now->copy()->startOfWeek();
        $startOfLastWeek = $startOfThisWeek->copy()->subWeek();

        $thisWeekSales = (float) Order::where('created_at', '>=', $startOfThisWeek)->sum('total');
        $lastWeekSales = (float) Order::whereBetween('created_at', [$startOfLastWeek, $startOfThisWeek])->sum('total');
        $salesChange = $lastWeekSales > 0 ? (($thisWeekSales - $lastWeekSales) / $lastWeekSales) * 100 : 0;

        $thisWeekOrders = (int) Order::where('created_at', '>=', $startOfThisWeek)->count();
        $lastWeekOrders = (int) Order::whereBetween('created_at', [$startOfLastWeek, $startOfThisWeek])->count();
        $ordersChange = $lastWeekOrders > 0 ? (($thisWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100 : 0;

        $monthlySalesRaw = Order::selectRaw('MONTH(created_at) as month_num, COALESCE(SUM(total),0) as total')
            ->whereYear('created_at', $now->year)
            ->groupBy('month_num')
            ->pluck('total', 'month_num')
            ->toArray();

        $monthlySales = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlySales[] = (float) ($monthlySalesRaw[$m] ?? 0);
        }

        $latestOrders = Order::latest()->limit(8)->get();

        return view('admin-backend.index', [
            'ordersCount' => Order::count(),
            'pendingReviews' => Review::where('status', 'pending')->count(),
            'newsletterCount' => NewsletterSubscription::count(),
            'salesTotal' => (float) Order::sum('total'),
            'salesChange' => $salesChange,
            'ordersThisWeek' => $thisWeekOrders,
            'ordersChange' => $ordersChange,
            'monthlySales' => $monthlySales,
            'latestOrders' => $latestOrders,
        ]);
    }
}
