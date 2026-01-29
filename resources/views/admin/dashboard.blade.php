@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Dashboard</h2>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <p class="card-text display-4">{{ $stats['bookings'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rooms</h5>
                    <p class="card-text display-4">{{ $stats['rooms'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text display-4">{{ $stats['users'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Blogs</h5>
                    <p class="card-text display-4">{{ $stats['blogs'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Recent Bookings</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->room->name }}</td>
                        <td>{{ $booking->check_in->format('M d') }}</td>
                        <td>{{ $booking->check_out->format('M d') }}</td>
                        <td>
                            <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
