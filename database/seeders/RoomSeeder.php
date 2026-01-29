<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::create([
            'name' => 'Double Room',
            'description' => 'Spacious double room with modern amenities',
            'price_per_night' => 199.00,
            'size' => '30 ft',
            'capacity' => 5,
            'bed_type' => 'King Beds',
            'services' => 'Wifi, Television, Bathroom, Air Conditioning',
            'image' => 'img/room/room-b1.jpg',
            'status' => 'available',
        ]);

        Room::create([
            'name' => 'Premium King Room',
            'description' => 'Luxury premium room with king size bed',
            'price_per_night' => 159.00,
            'size' => '30 ft',
            'capacity' => 5,
            'bed_type' => 'King Beds',
            'services' => 'Wifi, Television, Bathroom, Mini Bar',
            'image' => 'img/room/room-b2.jpg',
            'status' => 'available',
        ]);

        Room::create([
            'name' => 'Deluxe Room',
            'description' => 'Elegant deluxe room with premium facilities',
            'price_per_night' => 198.00,
            'size' => '30 ft',
            'capacity' => 5,
            'bed_type' => 'King Beds',
            'services' => 'Wifi, Television, Bathroom, Balcony',
            'image' => 'img/room/room-b3.jpg',
            'status' => 'available',
        ]);

        Room::create([
            'name' => 'Family Room',
            'description' => 'Perfect family room with extra space',
            'price_per_night' => 299.00,
            'size' => '30 ft',
            'capacity' => 5,
            'bed_type' => 'King Beds',
            'services' => 'Wifi, Television, Bathroom, Kitchen',
            'image' => 'img/room/room-b4.jpg',
            'status' => 'available',
        ]);
    }
}
