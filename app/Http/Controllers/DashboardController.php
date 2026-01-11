<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $stats = [

            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'maintenance_rooms' => Room::where('status', 'maintenance')->count(),
            

            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            

            'todays_checkins' => Booking::whereDate('check_in_date', Carbon::today())
                                        ->whereIn('status', ['confirmed', 'pending'])
                                        ->count(),
            'todays_checkouts' => Booking::whereDate('check_out_date', Carbon::today())
                                         ->where('status', 'checked_in')
                                         ->count(),
            

            'today_revenue' => Invoice::whereDate('created_at', Carbon::today())
                                     ->where('payment_status', 'paid')
                                     ->sum('total_amount'),
            'week_revenue' => Invoice::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->where('payment_status', 'paid')
                                    ->sum('total_amount'),
            'month_revenue' => Invoice::whereMonth('created_at', Carbon::now()->month)
                                     ->where('payment_status', 'paid')
                                     ->sum('total_amount'),
            

            'total_customers' => Customer::count(),
        ];
        

        $recentBookings = Booking::with(['customer', 'room'])
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
        

        $todaysCheckIns = Booking::with(['customer', 'room'])
                                 ->whereDate('check_in_date', Carbon::today())
                                 ->whereIn('status', ['confirmed', 'pending'])
                                 ->get();
        

        $todaysCheckOuts = Booking::with(['customer', 'room'])
                                  ->whereDate('check_out_date', Carbon::today())
                                  ->where('status', 'checked_in')
                                  ->get();
        

        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenueTrend[] = [
                'date' => $date->format('M d'),
                'revenue' => Invoice::whereDate('created_at', $date)
                                   ->where('payment_status', 'paid')
                                   ->sum('total_amount')
            ];
        }
        

        $bookingStats = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'checked_in' => Booking::where('status', 'checked_in')->count(),
            'checked_out' => Booking::where('status', 'checked_out')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        

        $roomTypes = Room::selectRaw('room_type, COUNT(*) as count')
                        ->groupBy('room_type')
                        ->get();
        

        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;
        

        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyRevenue[] = [
                'month' => $month->format('M'),
                'revenue' => Invoice::whereYear('created_at', $month->year)
                                   ->whereMonth('created_at', $month->month)
                                   ->where('payment_status', 'paid')
                                   ->sum('total_amount')
            ];
        }
        
        return view('dashboard', compact(
            'stats',
            'recentBookings',
            'todaysCheckIns',
            'todaysCheckOuts',
            'revenueTrend',
            'bookingStats',
            'roomTypes',
            'occupancyRate',
            'monthlyRevenue'
        ));
    }
}
