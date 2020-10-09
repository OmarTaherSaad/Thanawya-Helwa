<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSenderCustomMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name, $message, $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $name = '')
    {
        $this->name = $name;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('emails.admin-sender-custom-mail');
    }
}
