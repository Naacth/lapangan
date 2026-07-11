<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Customer Creates Booking
    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $field = Field::findOrFail($request->field_id);

        try {
            $booking = DB::transaction(function () use ($request, $field) {
                // Check double booking with lockForUpdate to prevent race condition
                $isBooked = Booking::where('field_id', $field->id)
                    ->where('booking_date', $request->booking_date)
                    ->where('start_time', $request->start_time)
                    ->whereIn('status', ['pending', 'confirmed', 'completed'])
                    ->lockForUpdate()
                    ->exists();

                if ($isBooked) {
                    throw ValidationException::withMessages([
                        'slot' => 'The selected time slot is already booked.'
                    ]);
                }

                // Calculate total price (simplified logic: hours * price)
                $start = Carbon::parse($request->start_time);
                $end = Carbon::parse($request->end_time);
                $hours = $end->diffInHours($start);
                if ($hours == 0) $hours = 1; // minimum 1 hour
                
                $totalPrice = $hours * $field->price_per_hour;

                $booking = Booking::create([
                    'user_id' => $request->user()->id,
                    'field_id' => $field->id,
                    'booking_date' => $request->booking_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'status' => 'pending',
                    'total_price' => $totalPrice,
                ]);

                // Create pending payment record
                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $totalPrice,
                    'status' => 'pending',
                ]);

                return $booking;
            });

            return response()->json(['message' => 'Booking created successfully', 'data' => $booking], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => collect($e->errors())->first()[0]], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating booking'], 500);
        }
    }

    // Customer Views their bookings
    public function me(Request $request)
    {
        $bookings = Booking::with(['field.venue', 'payment'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['data' => $bookings]);
    }

    // Customer cancels booking
    public function cancel(Request $request, $id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Only pending bookings can be cancelled by user'], 400);
        }

        $booking->update(['status' => 'cancelled']);
        return response()->json(['message' => 'Booking cancelled successfully']);
    }

    // Admin views all bookings
    public function index()
    {
        $bookings = Booking::with(['user', 'field.venue', 'payment'])->orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $bookings]);
    }

    // Admin updates status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,cancelled,completed'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        // Send notification here in Phase 2
        
        return response()->json(['message' => 'Status updated successfully', 'data' => $booking]);
    }
}
