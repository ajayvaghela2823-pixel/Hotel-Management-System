@extends('layouts.layout')

@section('title', 'My Bookings - Sona Hotel')

@section('content')
<style>
    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 12px;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }
    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    .btn-sm {
        padding: 5px 15px;
        font-size: 14px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #dfa974;
        color: white;
    }
    .btn-primary:hover {
        background-color: #c8926b;
    }
</style>
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-text">
                    <h1>My Bookings</h1>
                    <p>Manage your reservations and view your booking history.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}"></div>
    </div>
</section>

<section class="spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
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
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <a href="{{ route('room.details', $booking->room->id) }}">
                                                {{ $booking->room->name }}
                                            </a>
                                        </td>
                                        <td>{{ $booking->check_in->format('M d, Y') }}</td>
                                        <td>{{ $booking->check_out->format('M d, Y') }}</td>
                                        <td>{{ $booking->guests }}</td>
                                        <td>Rs{{ number_format($booking->total_price, 2) }}</td>
                                        <td>
                                            @if($booking->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($booking->status == 'confirmed')
                                                <span class="badge badge-success">Confirmed (Occupied)</span>
                                            @elseif($booking->status == 'completed')
                                                <span class="badge badge-info">Completed</span>
                                            @else
                                                <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($booking->status == 'confirmed')
                                                <form action="{{ route('booking.checkout', $booking) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you checking out?')">
                                                        Check Out
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 'completed')
                                                <span class="text-muted">Checked Out</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center">
                        <h3>No bookings found.</h3>
                        <p>You haven't made any reservations yet.</p>
                        <a href="{{ route('rooms') }}" class="primary-btn">Book a Room Now</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
