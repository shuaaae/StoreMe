<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyToUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $replyMessage;

    public function __construct($userName, $replyMessage)
    {
        $this->userName = $userName;
        $this->replyMessage = $replyMessage;
    }

    public function build()
    {
        return $this->subject('Response to Your StoreMe Inquiry')
                    ->view('emails.user-reply');
    }
}
