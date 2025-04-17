<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HelpMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $helpMessage;

    public function __construct($user, $helpMessage)
    {
        $this->user = $user;
        $this->helpMessage = $helpMessage;
    }

    public function build()
    {
        return $this->subject('New Help Request Submitted')
                    ->view('emails.help');
    }
}
