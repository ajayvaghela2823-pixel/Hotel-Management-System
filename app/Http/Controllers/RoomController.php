<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->paginate(12);
        return view('pages.rooms', compact('rooms'));
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        
        // Check if room is currently occupied
        $isOccupied = \App\Models\Booking::where('room_id', $id)
            ->where('status', 'confirmed')
            ->where('check_in', '<=', now())
            ->where('check_out', '>=', now())
            ->exists();
        
        $relatedRooms = Room::where('id', '!=', $id)
                           ->where('status', 'available')
                           ->take(3)
                           ->get();
        
        return view('pages.room-details', compact('room', 'relatedRooms', 'isOccupied'));
    }
}
