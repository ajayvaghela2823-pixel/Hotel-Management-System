<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Here you would typically send an email or save to database
        // For now, just redirect with success message

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
