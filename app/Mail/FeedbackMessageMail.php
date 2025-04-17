<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $rating;
    public $messageContent;

    public function __construct($user, $rating, $messageContent)
    {
        $this->user = $user;
        $this->rating = $rating;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('New Feedback Received')
                    ->view('emails.feedback');
    }
}
