<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms
     */
    public function index(Request $request)
    {
        $query = Room::query();
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by room type
        if ($request->has('room_type') && $request->room_type != '') {
            $query->where('room_type', $request->room_type);
        }
        
        // Filter by floor
        if ($request->has('floor') && $request->floor != '') {
            $query->where('floor', $request->floor);
        }
        
        // Search by room number
        if ($request->has('search') && $request->search != '') {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }
        
        $rooms = $query->orderBy('room_number')->paginate(10);
        
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created room
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type' => 'required|in:single,double,suite,deluxe',
            'floor' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    /**
     * Display the specified room
     */
    public function show(Room $room)
    {
        $room->load('bookings.customer');
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing a room
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified room
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|in:single,double,suite,deluxe',
            'floor' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully');
    }

    /**
     * Remove the specified room
     */
    public function destroy(Room $room)
    {
        // Check if room has active bookings
        if ($room->bookings()->whereNotIn('status', ['cancelled', 'checked_out'])->exists()) {
            return back()->with('error', 'Cannot delete room with active bookings');
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully');
    }
}
