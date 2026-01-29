@extends('layouts.admin')

@section('title', 'Manage Rooms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Manage Rooms</h2>
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add New Room</a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price/Night</th>
                                    <th>Size</th>
                                    <th>Capacity</th>
                                    <th>Bed Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                <tr>
                                    <td>{{ $room->id }}</td>
                                    <td>{{ $room->name }}</td>
                                    <td>Rs{{ number_format($room->price_per_night, 2) }}</td>
                                    <td>{{ $room->size }}</td>
                                    <td>{{ $room->capacity }} persons</td>
                                    <td>{{ $room->bed_type }}</td>
                                    <td>
                                        @if($room->status === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Booked</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No rooms found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
