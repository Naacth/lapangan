<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todayBookings = Booking::whereDate('booking_date', $today)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();

        $pendingBookings = Booking::where('status', 'pending')->count();

        $monthRevenue = Booking::whereBetween('booking_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        $totalFields = Field::where('is_active', true)->count();

        $recentBookings = Booking::with(['user', 'field.venue', 'payment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'todayBookings', 'pendingBookings', 'monthRevenue', 'totalFields', 'recentBookings'
        ));
    }
}
