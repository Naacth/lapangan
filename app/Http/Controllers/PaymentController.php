<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function upload(Request $request, $booking_id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::where('id', $booking_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            $payment->update([
                'payment_proof' => $path,
            ]);

            return response()->json([
                'message' => 'Payment proof uploaded successfully',
                'data' => $payment
            ]);
        }

        return response()->json(['message' => 'File upload failed'], 400);
    }
}
