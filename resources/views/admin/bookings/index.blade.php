@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Manage Bookings</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="card mt-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Guest</th>
                                    <th>Room</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Guests</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Booked On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ $booking->check_in->format('M d, Y') }}</td>
                                    <td>{{ $booking->check_out->format('M d, Y') }}</td>
                                    <td>{{ $booking->guests }}</td>
                                    <td>Rs{{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="badge bg-success">Confirmed (Occupied)</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="badge bg-info">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Confirm this booking?')">
                                                        Confirm
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Cancel this booking?')">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No bookings found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
