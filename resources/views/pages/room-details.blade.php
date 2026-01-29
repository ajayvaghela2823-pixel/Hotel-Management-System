@extends('layouts.layout')

@section('title', $room->name . ' - Sona Hotel')

@section('content')
    <style>
        .alert {
            padding: 12px 20px;
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
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }
    </style>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Our Rooms</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('rooms') }}">Rooms</a>
                            <span>{{ $room->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Room Details Section Begin -->
    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="room-details-item">
                        <img src="{{ asset($room->image) }}" alt="">
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>{{ $room->name }}</h3>
                                <div class="rdt-right">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star-half_alt"></i>
                                    </div>
                                    <a href="#">Booking Now</a>
                                </div>
                            </div>
                            <h2>Rs {{ $room->price_per_night }}<span>/Per Night</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>{{ $room->size }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>Max persion {{ $room->capacity }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Bed:</td>
                                        <td>{{ $room->bed_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Services:</td>
                                        <td>{{ $room->services }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="f-para">{{ $room->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="room-booking">
                        <h3>Your Reservation</h3>
                        
                        @if($isOccupied)
                            <div class="alert alert-warning" style="background-color: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                                <strong>⚠️ Room Occupied</strong>
                                <p style="margin: 5px 0 0 0;">This room is currently occupied and not available for booking.</p>
                            </div>
                        @endif
                        
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
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @guest
                            <div class="alert alert-info">
                                Please <a href="{{ route('login') }}" style="color: #1f3bb3; font-weight: bold;">login</a> to book this room.
                            </div>
                        @endguest
                        
                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <div class="check-date">
                                <label for="date-in">Check In:</label>
                                <input type="text" class="date-input" id="date-in" name="check_in" 
                                       {{ $isOccupied ? 'disabled' : 'required' }}>
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Check Out:</label>
                                <input type="text" class="date-input" id="date-out" name="check_out" 
                                       {{ $isOccupied ? 'disabled' : 'required' }}>
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label for="guest">Guests:</label>
                                <select id="guest" name="guests" {{ $isOccupied ? 'disabled' : '' }}>
                                    @for($i = 1; $i <= $room->capacity; $i++)
                                        <option value="{{ $i }}">{{ $i }} Person</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="select-option">
                                <label for="room_name">Room:</label>
                                <input type="text" value="{{ $room->name }}" readonly style="width: 100%; border: none; font-weight: bold; color: #707079;">
                            </div>
                            @auth
                                @if($isOccupied)
                                    <button type="button" disabled style="background: #ccc; cursor: not-allowed; opacity: 0.6;">Room Occupied</button>
                                @else
                                    <button type="submit">Book Now</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary" style="display: block; text-align: center; padding: 13px 28px; background: #dfa974; border: none; color: #ffffff; text-decoration: none;">Login to Book</a>
                            @endauth
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Room Details Section End -->
@endsection
