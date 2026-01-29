<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('published_at', '<=', now())
                    ->latest('published_at')
                    ->paginate(9);
        
        return view('pages.blog', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $recentBlogs = Blog::where('id', '!=', $blog->id)
                          ->where('published_at', '<=', now())
                          ->latest('published_at')
                          ->take(3)
                          ->get();
        
        return view('pages.blog-details', compact('blog', 'recentBlogs'));
    }
}
