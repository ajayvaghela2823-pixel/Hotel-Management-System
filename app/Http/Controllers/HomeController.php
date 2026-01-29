<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->take(4)->get();
        $blogs = Blog::where('published_at', '<=', now())->latest('published_at')->take(5)->get();
        
        return view('pages.home', compact('rooms', 'blogs'));
    }
}
