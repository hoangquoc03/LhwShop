<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivateUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newUser;   // để dùng trong blade
    public $activationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($newUser)
    {
        $this->newUser = $newUser;
        $this->activationUrl = route('frontend.register.active-user', [
            'token' => $newUser->activate_code
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kích hoạt tài khoản của bạn'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.activate-user',
            with: [
                'newUser' => $this->newUser,
                'activationUrl' => $this->activationUrl
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}