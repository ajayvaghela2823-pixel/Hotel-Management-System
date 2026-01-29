@extends('layouts.layout')

@section('title', 'Contact Us - Sona Hotel')

@section('content')
    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Contact Info</h2>
                        <p>Experience luxury and comfort at Sona Hotel, located at the prestigious Marwadi University campus in Rajkot.</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Address:</td>
                                    <td>Morbi Road, Marwadi University, Rajkot</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Phone:</td>
                                    <td>+91 9106330780</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td>hotel@sora.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="Your Name" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Your Email" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="Your Message" required></textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <button type="submit">Submit Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3689.6313233456767!2d70.79462937602435!3d22.367545529638303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1smarwadi%20university!5e0!3m2!1sen!2sin!4v1769613622250!5m2!1sen!2sin" 
                    height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
@endsection
