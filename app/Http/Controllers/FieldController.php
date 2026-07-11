<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Booking;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function availability($id, Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $field = Field::findOrFail($id);
        $date = $request->date;

        // Get all confirmed or pending bookings for this date
        $bookings = Booking::where('field_id', $id)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->get(['start_time', 'end_time', 'status']);

        return response()->json([
            'message' => 'Availability retrieved',
            'data' => [
                'field' => $field,
                'date' => $date,
                'booked_slots' => $bookings
            ]
        ]);
    }

    public function store(Request $request)
    {
        // Admin only (validation can be extended)
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'name' => 'required|string',
            'sport_type' => 'required|string',
            'price_per_hour' => 'required|numeric',
        ]);

        $field = Field::create($request->all());

        return response()->json(['message' => 'Field created', 'data' => $field], 201);
    }

    public function update(Request $request, $id)
    {
        // Admin only
        $field = Field::findOrFail($id);
        $field->update($request->all());

        return response()->json(['message' => 'Field updated', 'data' => $field]);
    }
}
