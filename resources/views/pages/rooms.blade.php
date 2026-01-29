@extends('layouts.layout')

@section('title', 'All Rooms - Sona Hotel')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Our Rooms</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Rooms</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                @foreach($rooms as $room)
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="{{ asset($room->image) }}" alt="">
                        <div class="ri-text">
                            <h4>{{ $room->name }}</h4>
                            <h3>Rs {{ $room->price_per_night }}<span>/Per Night</span></h3>
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
                                        <td>{{ Str::limit($room->services, 30) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('room.details', $room->id) }}" class="primary-btn">More Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="col-lg-12">
                    <div class="room-pagination">
                        {{ $rooms->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->
@endsection
