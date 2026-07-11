<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Simple report: revenue by day for the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $bookings = Booking::whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['confirmed', 'completed'])
            ->get();

        $totalRevenue = $bookings->sum('total_price');
        $totalBookings = $bookings->count();

        return response()->json([
            'message' => 'Monthly Report',
            'data' => [
                'month' => Carbon::now()->format('F Y'),
                'total_revenue' => $totalRevenue,
                'total_bookings' => $totalBookings,
                'bookings' => $bookings
            ]
        ]);
    }
}
