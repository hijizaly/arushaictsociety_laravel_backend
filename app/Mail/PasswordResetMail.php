<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->markdown('send-code-reset-password');
    }

//    /**
//     * Create a new message instance.
//     *
//     * @return void
//     */
//    public function __construct($mailData)
//    {
//        $this->mailData = $mailData;
//    }
//
//    /**
//     * Get the message envelope.
//     *
//     * @return \Illuminate\Mail\Mailables\Envelope
//     */
//    public function envelope()
//    {
//        return new Envelope(
//            subject: 'Password Reset Mail',
//        );
//    }
//
//    /**
//     * Get the message content definition.
//     *
//     * @return \Illuminate\Mail\Mailables\Content
//     */
//    public function content()
//    {
//        return new Content(
//            view: 'send-code-reset-password',
//        );
//    }
//
//    /**
//     * Get the attachments for the message.
//     *
//     * @return array
//     */
//    public function attachments()
//    {
//        return [];
//    }
}
