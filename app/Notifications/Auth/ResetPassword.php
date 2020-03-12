<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword as RP;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends RP implements ShouldQueue
{
    use Queueable;
}
