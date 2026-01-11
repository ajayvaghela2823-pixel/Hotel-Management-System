<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'room']);
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('check_in_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('check_out_date', '<=', $request->end_date);
        }
        
        $bookings = $query->orderBy('check_in_date', 'desc')->paginate(10);
        
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $rooms = Room::where('status', 'available')->orderBy('room_number')->get();
        
        return view('bookings.create', compact('customers', 'rooms'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string',
        ]);

        // Check for date conflicts
        if (Booking::hasConflict($validated['room_id'], $validated['check_in_date'], $validated['check_out_date'])) {
            return back()->withInput()->with('error', 'Room is not available for the selected dates');
        }

        // Calculate total amount
        $room = Room::find($validated['room_id']);
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $nights * $room->price_per_night;

        $booking = Booking::create([
            'customer_id' => $validated['customer_id'],
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_amount' => $totalAmount,
            'status' => 'confirmed',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created successfully');
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['customer', 'room', 'checkIn', 'invoice']);
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing a booking
     */
    public function edit(Booking $booking)
    {
        if (in_array($booking->status, ['checked_out', 'cancelled'])) {
            return back()->with('error', 'Cannot edit completed or cancelled bookings');
        }
        
        $customers = Customer::orderBy('name')->get();
        $rooms = Room::where('status', 'available')
                     ->orWhere('id', $booking->room_id)
                     ->orderBy('room_number')
                     ->get();
        
        return view('bookings.edit', compact('booking', 'customers', 'rooms'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, Booking $booking)
    {
        if (in_array($booking->status, ['checked_out', 'cancelled'])) {
            return back()->with('error', 'Cannot update completed or cancelled bookings');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string',
        ]);

        // Check for date conflicts (excluding current booking)
        if (Booking::hasConflict($validated['room_id'], $validated['check_in_date'], $validated['check_out_date'], $booking->id)) {
            return back()->withInput()->with('error', 'Room is not available for the selected dates');
        }

        // Recalculate total amount
        $room = Room::find($validated['room_id']);
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $nights * $room->price_per_night;

        $booking->update([
            'customer_id' => $validated['customer_id'],
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_amount' => $totalAmount,
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking updated successfully');
    }

    /**
     * Cancel a booking
     */
    public function destroy(Booking $booking)
    {
        if (in_array($booking->status, ['checked_out', 'cancelled'])) {
            return back()->with('error', 'Cannot cancel completed or already cancelled bookings');
        }

        $booking->cancelBooking();

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully');
    }
}
