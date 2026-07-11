<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        $bookings = Booking::with(['field.venue', 'user'])
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderBy('booking_date')
            ->get();

        $totalRevenue = $bookings->sum('total_price');
        $totalBookings = $bookings->count();

        // Revenue per day chart data
        $revenueByDay = $bookings->groupBy(function ($b) {
            return Carbon::parse($b->booking_date)->format('d');
        })->map(fn($g) => $g->sum('total_price'));

        // Revenue per sport type
        $revenueBySport = $bookings->groupBy(function ($b) {
            return $b->field->sport_type ?? 'Unknown';
        })->map(fn($g) => $g->sum('total_price'));

        return view('admin.reports.index', compact(
            'bookings', 'totalRevenue', 'totalBookings', 'month', 'revenueByDay', 'revenueBySport'
        ));
    }

    public function exportCsv(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        $bookings = Booking::with(['field.venue', 'user'])
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderBy('booking_date')
            ->get();

        $filename = 'laporan-' . $month . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($bookings, $month) {
            $handle = fopen('php://output', 'w');

            // BOM agar Excel bisa baca UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header baris info
            fputcsv($handle, ['Laporan Pendapatan Bulan ' . Carbon::parse($month)->translatedFormat('F Y')], ';');
            fputcsv($handle, ['Dicetak pada: ' . Carbon::now()->format('d/m/Y H:i') . ' WIB'], ';');
            fputcsv($handle, [], ';');

            // Header kolom
            fputcsv($handle, [
                'No',
                'Customer',
                'Lapangan',
                'Jenis Olahraga',
                'Tanggal',
                'Waktu Mulai',
                'Waktu Selesai',
                'Total Harga',
                'Status',
            ], ';');

            $no = 1;
            $totalRevenue = 0;
            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $no++,
                    $booking->user->name ?? '-',
                    $booking->field->name ?? '-',
                    $booking->field->sport_type ?? '-',
                    Carbon::parse($booking->booking_date)->format('d/m/Y'),
                    substr($booking->start_time, 0, 5),
                    substr($booking->end_time, 0, 5),
                    $booking->total_price,
                    ucfirst($booking->status),
                ], ';');
                $totalRevenue += $booking->total_price;
            }

            // Baris total
            fputcsv($handle, [], ';');
            fputcsv($handle, ['', '', '', '', '', '', 'TOTAL', $totalRevenue, ''], ';');

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        $bookings = Booking::with(['field.venue', 'user'])
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderBy('booking_date')
            ->get();

        $totalRevenue = $bookings->sum('total_price');
        $totalBookings = $bookings->count();

        $revenueBySport = $bookings->groupBy(function ($b) {
            return $b->field->sport_type ?? 'Unknown';
        })->map(fn($g) => $g->sum('total_price'));

        return view('admin.reports.pdf', compact(
            'bookings', 'totalRevenue', 'totalBookings', 'month', 'revenueBySport'
        ));
    }
}
