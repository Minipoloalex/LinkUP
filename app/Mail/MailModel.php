<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;

class MailModel extends Mailable
{
    public $mailData;

    /**
     * Create a new mail instance.
     * 
     * @param  array  $mailData 
     * @return void
     */
    public function __construct($mailData) {
        $this->mailData = $mailData;
    }

    public function envelope() {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: $this->mailData['subject'],
        );
    }

    public function content() {
        return new Content(
            view: $this->mailData['view'],
        );
    }
}