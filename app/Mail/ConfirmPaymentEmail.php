<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmPaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $courses;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($courses)
    {
        $this->courses = $courses;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de paiement! #'.$courses[0]->reference)
        ->view('emails.confirm_payment');
    }
}
