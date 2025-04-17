<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\HelpMessageMail;
use App\Mail\FeedbackMessageMail;
use App\Mail\ReplyToUserMail;


class ContactController extends Controller
{
    public function submitHelp(Request $request)
    {
        $user = Auth::user();

        Mail::to('hellostoreme@gmail.com')->send(
            new HelpMessageMail($user, $request->help_message)
        );

        return back()->with('status', 'Your help message has been sent!');
    }

    public function submitFeedback(Request $request)
    {
        $user = Auth::user();

        Mail::to('hellostoreme@gmail.com')->send(
            new FeedbackMessageMail($user, $request->rating, $request->feedback_message)
        );

        return back()->with('status', 'Thank you! Your feedback has been sent.');
    }
    public function replyToUser(Request $request)
{
    $user = User::find($request->user_id); // or however you're referencing the user
    $message = $request->reply_message;

    Mail::to($user->email)->send(new ReplyToUserMail($user->name, $message));

    return back()->with('status', 'Reply sent successfully!');
}
}
