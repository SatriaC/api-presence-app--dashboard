<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'no-reply@kiselgroup.com';
        // $address_bcc1 = 'it-corporate@kiselgroup.com';
        $subject = 'Permintaan Reset Password';
        return $this->view('pages.email-reset')
        ->from($address, 'Building Management')
        //  ->bcc([$address_bcc1])
        // ->bcc($address, $name)
         // ->replyTo($address, $name)
         ->subject($subject)
         ->with(
         [
            'user' => $this->user,

         ]);
    }
}
