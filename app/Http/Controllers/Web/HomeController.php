<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $venues = Venue::with('fields')->get();
        return view('home.index', compact('venues'));
    }

    public function field($id)
    {
        $field = Field::with(['venue', 'schedules'])->findOrFail($id);
        return view('home.field', compact('field'));
    }

    public function checkAvailability(Request $request, $id)
    {
        $request->validate(['date' => 'required|date']);

        $field = Field::findOrFail($id);
        $bookedSlots = Booking::where('field_id', $id)
            ->where('booking_date', $request->date)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->get(['start_time', 'end_time']);

        return response()->json(['booked_slots' => $bookedSlots]);
    }
}
