<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function submitHelp(Request $request)
    {
        // You may process or store the help message if needed
        return back()->with('status', 'Help message submitted!');
    }

    public function submitFeedback(Request $request)
    {
        $user = Auth::user();

        Mail::raw("Rating: {$request->rating}\n\nMessage:\n{$request->feedback_message}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Feedback Submission');
        });

        return back()->with('status', 'Thank you for your feedback!');
    }
}
