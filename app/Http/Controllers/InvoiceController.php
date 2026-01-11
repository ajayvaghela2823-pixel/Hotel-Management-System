<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices
     */
    public function index(Request $request)
    {
        $query = Invoice::with('booking.customer');
        
        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice
     */
    public function create(Request $request)
    {
        $bookingId = $request->get('booking');
        $booking = null;
        
        if ($bookingId) {
            $booking = Booking::with(['customer', 'room'])->find($bookingId);
            
            // Check if invoice already exists
            if ($booking && $booking->invoice) {
                return redirect()->route('invoices.show', $booking->invoice)
                       ->with('info', 'Invoice already exists for this booking');
            }
        }
        
        $bookings = Booking::with(['customer', 'room'])
                           ->where('status', 'checked_out')
                           ->whereDoesntHave('invoice')
                           ->orderBy('check_out_date', 'desc')
                           ->get();
        
        return view('invoices.create', compact('bookings', 'booking'));
    }

    /**
     * Store a newly created invoice
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cash,card,online,other',
        ]);

        $booking = Booking::with('room')->find($validated['booking_id']);
        
        // Check if invoice already exists
        if ($booking->invoice) {
            return redirect()->route('invoices.show', $booking->invoice)
                   ->with('error', 'Invoice already exists for this booking');
        }

        $subtotal = $booking->total_amount;
        $discount = $validated['discount'] ?? 0;
        $tax = $subtotal * 0.10; // 10% tax
        $total = $subtotal + $tax - $discount;

        $invoice = Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total_amount' => $total,
            'payment_status' => 'paid', // Mark as paid immediately
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice generated successfully');
    }

    /**
     * Display the specified invoice
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['booking.customer', 'booking.room']);
        
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Update payment status
     */
    public function updatePayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,partially_paid,refunded',
            'payment_method' => 'nullable|in:cash,card,online,other',
        ]);

        $invoice->update($validated);

        return back()->with('success', 'Payment status updated successfully');
    }

    /**
     * Remove the specified invoice
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->payment_status === 'paid') {
            return back()->with('error', 'Cannot delete paid invoices');
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully');
    }
}
