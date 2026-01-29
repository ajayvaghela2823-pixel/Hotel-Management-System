<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::create([
            'title' => 'Tremblant In Canada',
            'slug' => Str::slug('Tremblant In Canada'),
            'content' => 'Discover the beautiful Tremblant resort in Canada. Experience world-class skiing and stunning mountain views.',
            'excerpt' => 'Discover the beautiful Tremblant resort in Canada',
            'image' => 'img/blog/blog-1.jpg',
            'category' => 'Travel Trip',
            'author_id' => 1,
            'published_at' => now()->subDays(10),
        ]);

        Blog::create([
            'title' => 'Choosing A Static Caravan',
            'slug' => Str::slug('Choosing A Static Caravan'),
            'content' => 'Guide to choosing the perfect static caravan for your camping adventures. Tips and recommendations included.',
            'excerpt' => 'Guide to choosing the perfect static caravan',
            'image' => 'img/blog/blog-2.jpg',
            'category' => 'Camping',
            'author_id' => 1,
            'published_at' => now()->subDays(8),
        ]);

        Blog::create([
            'title' => 'Copper Canyon',
            'slug' => Str::slug('Copper Canyon'),
            'content' => 'Explore the magnificent Copper Canyon, one of Mexico\'s most spectacular natural wonders.',
            'excerpt' => 'Explore the magnificent Copper Canyon',
            'image' => 'img/blog/blog-3.jpg',
            'category' => 'Event',
            'author_id' => 1,
            'published_at' => now()->subDays(5),
        ]);

        Blog::create([
            'title' => 'Trip To Iqaluit In Nunavut A Canadian Arctic City',
            'slug' => Str::slug('Trip To Iqaluit In Nunavut A Canadian Arctic City'),
            'content' => 'Journey to the Canadian Arctic and discover the unique culture and landscape of Iqaluit.',
            'excerpt' => 'Journey to the Canadian Arctic',
            'image' => 'img/blog/blog-wide.jpg',
            'category' => 'Event',
            'author_id' => 1,
            'published_at' => now()->subDays(3),
        ]);

        Blog::create([
            'title' => 'Traveling To Barcelona',
            'slug' => Str::slug('Traveling To Barcelona'),
            'content' => 'Experience the vibrant culture, stunning architecture, and delicious cuisine of Barcelona, Spain.',
            'excerpt' => 'Experience the vibrant culture of Barcelona',
            'image' => 'img/blog/blog-10.jpg',
            'category' => 'Travel',
            'author_id' => 1,
            'published_at' => now()->subDays(1),
        ]);
    }
}
