<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckInController extends Controller
{
    /**
     * Display today's check-ins and check-outs
     */
    public function index()
    {
        $todaysCheckIns = Booking::with(['customer', 'room'])
                                 ->whereDate('check_in_date', Carbon::today())
                                 ->whereIn('status', ['confirmed', 'pending'])
                                 ->get();
        
        $todaysCheckOuts = Booking::with(['customer', 'room', 'checkIn'])
                                  ->whereDate('check_out_date', Carbon::today())
                                  ->where('status', 'checked_in')
                                  ->get();
        
        $currentlyCheckedIn = Booking::with(['customer', 'room', 'checkIn'])
                                     ->where('status', 'checked_in')
                                     ->get();
        
        return view('checkin.index', compact('todaysCheckIns', 'todaysCheckOuts', 'currentlyCheckedIn'));
    }

    /**
     * Process check-in
     */
    public function checkIn(Request $request, Booking $booking)
    {
        if ($booking->status !== 'confirmed' && $booking->status !== 'pending') {
            return back()->with('error', 'This booking cannot be checked in');
        }

        // Create check-in record
        CheckIn::create([
            'booking_id' => $booking->id,
            'staff_id' => auth()->id(),
            'actual_check_in' => Carbon::now(),
        ]);

        // Update booking status
        $booking->update(['status' => 'checked_in']);
        
        // Update room status
        $booking->room->markAsOccupied();

        return back()->with('success', 'Guest checked in successfully');
    }

    /**
     * Process check-out
     */
    public function checkOut(Request $request, Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return back()->with('error', 'This booking is not checked in');
        }

        // Update check-in record
        $checkIn = $booking->checkIn;
        if ($checkIn) {
            $checkIn->update(['actual_check_out' => Carbon::now()]);
        }

        // Update booking status
        $booking->update(['status' => 'checked_out']);
        
        // Update room status
        $booking->room->markAsAvailable();

        return redirect()->route('invoices.create', ['booking' => $booking->id])
               ->with('success', 'Guest checked out successfully. Please generate invoice.');
    }
}
