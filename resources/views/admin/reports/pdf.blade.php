<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan – {{ \Carbon\Carbon::parse($month)->format('F Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a2e; background: #fff; }

        .page { max-width: 900px; margin: 0 auto; padding: 32px; }

        /* Header */
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #2563EB; padding-bottom: 16px; margin-bottom: 24px; }
        .header-left h1 { font-size: 20px; font-weight: 900; color: #2563EB; }
        .header-left p { color: #64748B; font-size: 11px; margin-top: 4px; }
        .header-right { text-align: right; }
        .header-right .badge-month { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 700; }
        .header-right .print-info { font-size: 10px; color: #94A3B8; margin-top: 6px; }

        /* Stats */
        .stats { display: flex; gap: 16px; margin-bottom: 24px; }
        .stat-box { flex: 1; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 16px; text-align: center; }
        .stat-box .label { font-size: 10px; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .stat-box .value { font-size: 18px; font-weight: 900; }
        .stat-box.revenue .value { color: #16A34A; }
        .stat-box.count .value   { color: #2563EB; }
        .stat-box.avg .value     { color: #D97706; }

        /* Sport breakdown */
        .section-title { font-size: 13px; font-weight: 700; margin-bottom: 10px; color: #1E293B; }
        .sport-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #F1F5F9; font-size: 11px; }
        .sport-row:last-child { border-bottom: none; }
        .sport-row .sport-name { font-weight: 600; }
        .sport-row .sport-rev { color: #2563EB; font-weight: 700; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 8px; }
        thead th { background: #1E3A5F; color: #fff; padding: 8px 10px; text-align: left; font-weight: 700; }
        tbody tr:nth-child(even) { background: #F8FAFC; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #E2E8F0; vertical-align: middle; }
        tfoot td { padding: 8px 10px; font-weight: 700; background: #EFF6FF; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .status-confirmed { color: #16A34A; font-weight: 600; }
        .status-completed { color: #2563EB; font-weight: 600; }

        /* Print button – hidden when printing */
        .print-bar { display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 24px; }
        .btn-print { background: #2563EB; color: #fff; border: none; border-radius: 8px; padding: 9px 20px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-print:hover { background: #1D4ED8; }
        .btn-back  { background: #F1F5F9; color: #334155; border: none; border-radius: 8px; padding: 9px 20px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }

        .footer { margin-top: 32px; border-top: 1px solid #E2E8F0; padding-top: 12px; text-align: center; font-size: 10px; color: #94A3B8; }

        @media print {
            .print-bar { display: none !important; }
            body { font-size: 11px; }
            .page { padding: 16px; max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- Print / Back buttons --}}
    <div class="print-bar">
        <a href="{{ route('admin.reports.index', ['month' => $month]) }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <h1>📊 Laporan Pendapatan</h1>
            <p>SportBook — Sistem Manajemen Lapangan Olahraga</p>
        </div>
        <div class="header-right">
            <div class="badge-month">{{ \Carbon\Carbon::parse($month)->format('F Y') }}</div>
            <div class="print-info">Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} WIB</div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats">
        <div class="stat-box revenue">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box count">
            <div class="label">Total Booking</div>
            <div class="value">{{ $totalBookings }}</div>
        </div>
        <div class="stat-box avg">
            <div class="label">Rata-rata / Booking</div>
            <div class="value">Rp {{ $totalBookings > 0 ? number_format($totalRevenue / $totalBookings, 0, ',', '.') : '0' }}</div>
        </div>
    </div>

    {{-- Sport breakdown --}}
    @if($revenueBySport->count())
    <div style="margin-bottom: 24px;">
        <div class="section-title">Pendapatan per Jenis Olahraga</div>
        @foreach($revenueBySport as $sport => $rev)
        <div class="sport-row">
            <span class="sport-name">{{ $sport }}</span>
            <span class="sport-rev">Rp {{ number_format($rev, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Booking Table --}}
    <div class="section-title">Detail Booking</div>
    @if($bookings->isEmpty())
        <p style="color:#94A3B8; text-align:center; padding: 24px 0;">Tidak ada data booking bulan ini.</p>
    @else
    <table>
        <thead>
            <tr>
                <th class="text-center" style="width:32px">No</th>
                <th>Customer</th>
                <th>Lapangan</th>
                <th>Olahraga</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th class="text-right">Total</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $i => $booking)
            <tr>
                <td class="text-center" style="color:#94A3B8">{{ $i + 1 }}</td>
                <td style="font-weight:600">{{ $booking->user->name ?? '—' }}</td>
                <td>{{ $booking->field->name ?? '—' }}</td>
                <td>{{ $booking->field->sport_type ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                <td style="white-space:nowrap">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</td>
                <td class="text-right" style="color:#2563EB; font-weight:700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                <td class="text-center {{ 'status-' . $booking->status }}">{{ ucfirst($booking->status) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right" style="color:#16A34A">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    @endif

    <div class="footer">
        Laporan ini digenerate otomatis oleh sistem SportBook &bull; {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB
    </div>
</div>
</body>
</html>
