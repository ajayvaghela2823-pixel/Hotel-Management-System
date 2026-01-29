@extends('layouts.layout')

@section('title', $blog->title . ' - Sona Hotel')

@section('content')
    <!-- Blog Details Hero Section Begin -->
    <section class="blog-details-hero set-bg" data-setbg="{{ asset('img/blog/blog-details/blog-details-hero.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="bd-hero-text">
                        <span>{{ $blog->category }}</span>
                        <h2>{{ $blog->title }}</h2>
                        <ul>
                            <li class="b-time"><i class="icon_clock_alt"></i> {{ $blog->published_at->format('jS F, Y') }}</li>
                            <li><i class="icon_profile"></i> {{ $blog->author->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="blog-details-text">
                        <div class="bd-title">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                        <div class="tag-share">
                            <div class="tags">
                                <a href="#">{{ $blog->category }}</a>
                            </div>
                            <div class="social-share">
                                <span>Share:</span>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-tripadvisor"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Recommend Blog Section Begin -->
    <section class="recommend-blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Recommended</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($recentBlogs as $recentBlog)
                <div class="col-md-4">
                    <div class="blog-item set-bg" data-setbg="{{ asset($recentBlog->image) }}">
                        <div class="bi-text">
                            <span class="b-tag">{{ $recentBlog->category }}</span>
                            <h4><a href="{{ route('blog.details', $recentBlog->slug) }}">{{ $recentBlog->title }}</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> {{ $recentBlog->published_at->format('jS F, Y') }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Recommend Blog Section End -->
@endsection
