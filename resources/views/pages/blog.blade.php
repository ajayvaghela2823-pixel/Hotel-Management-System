@extends('layouts.layout')

@section('title', 'Hotel News - Sona Hotel')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Blog</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Blog Grid</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item set-bg" data-setbg="{{ asset($blog->image) }}">
                        <div class="bi-text">
                            <span class="b-tag">{{ $blog->category }}</span>
                            <h4><a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> {{ $blog->published_at->format('jS F, Y') }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="col-lg-12">
                    <div class="load-more">
                        {{ $blogs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
