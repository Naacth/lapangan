<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function create($field_id)
    {
        $field = Field::with('venue')->findOrFail($field_id);
        return view('bookings.create', compact('field'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id'       => 'required|exists:fields,id',
            'booking_date'   => 'required|date|after_or_equal:today',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
            'payment_method' => 'required|in:transfer,cash',
        ]);

        $field = Field::findOrFail($request->field_id);

        try {
            $booking = DB::transaction(function () use ($request, $field) {
                $isBooked = Booking::where('field_id', $field->id)
                    ->where('booking_date', $request->booking_date)
                    ->where('start_time', $request->start_time . ':00')
                    ->whereIn('status', ['pending', 'confirmed', 'completed'])
                    ->lockForUpdate()
                    ->exists();

                if ($isBooked) {
                    throw ValidationException::withMessages([
                        'slot' => 'Slot waktu tersebut sudah dipesan, silakan pilih waktu lain.'
                    ]);
                }

                $start = Carbon::parse($request->start_time);
                $end   = Carbon::parse($request->end_time);
                $hours = $end->diffInHours($start);
                if ($hours == 0) $hours = 1;

                $totalPrice = $hours * $field->price_per_hour;

                $booking = Booking::create([
                    'user_id'      => Auth::id(),
                    'field_id'     => $field->id,
                    'booking_date' => $request->booking_date,
                    'start_time'   => $request->start_time . ':00',
                    'end_time'     => $request->end_time . ':00',
                    'status'       => 'pending',
                    'total_price'  => $totalPrice,
                ]);

                Payment::create([
                    'booking_id'     => $booking->id,
                    'amount'         => $totalPrice,
                    'status'         => 'pending',
                    'payment_method' => $request->payment_method,
                ]);

                return $booking;
            });

            // Kalau bayar di tempat, langsung ke riwayat — tidak perlu upload bukti
            if ($request->payment_method === 'cash') {
                return redirect()->route('bookings.history')
                    ->with('success', 'Booking berhasil! Silakan bayar di tempat saat datang.');
            }

            return redirect()->route('bookings.upload', $booking->id)
                ->with('success', 'Booking berhasil dibuat! Silakan upload bukti pembayaran.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.')->withInput();
        }
    }

    public function history()
    {
        $bookings = Booking::with(['field.venue', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('bookings.history', compact('bookings'));
    }

    public function showUpload($id)
    {
        $booking = Booking::with(['field.venue', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('bookings.upload', compact('booking'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();

        $path = $request->file('payment_proof')->store('payments', 'public');
        $payment->update(['payment_proof' => $path]);

        return redirect()->route('bookings.history')
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking dengan status pending yang dapat dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);
        return redirect()->route('bookings.history')->with('success', 'Booking berhasil dibatalkan.');
    }
}
