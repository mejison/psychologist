<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EamilCallbackForm extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $message_text;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(\App\Models\ApplicationModels\User $user, $message)
    {
        $this->user = $user;
        $this->message_text = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Specialistuddannelse.dk feedback")
            ->view('emails.callback')
            ->with(['user' => $this->user, 'message' => $this->message_text]);
    }
}
