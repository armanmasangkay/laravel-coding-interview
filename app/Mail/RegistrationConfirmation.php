<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $number;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$number)
    {
        $this->email=$email;
        $this->number=$number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.registration-confirmation')
                    ->subject('Confirm Registration')
                    ->to($this->email);
    }
}
