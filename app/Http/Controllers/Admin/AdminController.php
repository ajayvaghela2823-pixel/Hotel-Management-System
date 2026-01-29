<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Blog;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'rooms' => Room::count(),
            'bookings' => Booking::count(),
            'blogs' => Blog::count(),
        ];

        $recentBookings = Booking::with(['user', 'room'])
                                ->latest()
                                ->take(10)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
