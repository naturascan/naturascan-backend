<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pseudo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouveau Badge Obtenu !')
        ->view('emails.accept_verification');
    }
}
