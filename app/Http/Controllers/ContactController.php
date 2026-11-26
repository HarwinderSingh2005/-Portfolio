<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: real users never fill this hidden field.
        if (filled($request->input('website'))) {
            return back()->withErrors(['website' => 'Invalid form submission detected.']);
        }

        $data = $request->validate([
            'full_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['required', 'string', 'min:3', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        ContactMessage::create($data);

        return redirect('/#contact')->with(
            'success',
            'Thank you! Your inquiry has been recorded. Harwinder will respond via email.'
        );
    }
}
