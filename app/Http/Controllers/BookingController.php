<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Convert date format if needed (e.g., "28 JANUARY, 2026" to "2026-01-28")
        if ($request->check_in) {
            try {
                $checkIn = \Carbon\Carbon::parse($request->check_in)->format('Y-m-d');
                $request->merge(['check_in' => $checkIn]);
            } catch (\Exception $e) {
                // If parsing fails, validation will catch it
            }
        }
        
        if ($request->check_out) {
            try {
                $checkOut = \Carbon\Carbon::parse($request->check_out)->format('Y-m-d');
                $request->merge(['check_out' => $checkOut]);
            } catch (\Exception $e) {
                // If parsing fails, validation will catch it
            }
        }
        
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ]);


        $room = Room::findOrFail($request->room_id);
        
        // Check if room is available for requested dates
        $hasConfirmedBooking = Booking::where('room_id', $request->room_id)
            ->where('status', 'confirmed')
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                    ->orWhere(function($q) use ($request) {
                        $q->where('check_in', '<=', $request->check_in)
                          ->where('check_out', '>=', $request->check_out);
                    });
            })
            ->exists();
        
        if ($hasConfirmedBooking) {
            return back()->with('error', 'This room is already occupied for the selected dates. Please choose different dates or another room.');
        }
        
        // Calculate total price
        $days = \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out);
        $totalPrice = $room->price_per_night * $days;

        Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('my.bookings')->with('success', 'Booking created successfully!');
    }

    public function myBookings()
    {
        $bookings = auth()->user()->bookings()->with('room')->latest()->get();
        return view('pages.my-bookings', compact('bookings'));
    }
    
    public function checkout(Booking $booking)
    {
        // Ensure user owns this booking
        if ($booking->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        // Only confirmed bookings can be checked out
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be checked out.');
        }
        
        // Update booking status to completed
        $booking->update(['status' => 'completed']);
        
        return back()->with('success', 'Successfully checked out! Thank you for staying with us.');
    }
}
