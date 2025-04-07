<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\ResetPassword;

class QueuedResetPassword extends ResetPassword implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

}
