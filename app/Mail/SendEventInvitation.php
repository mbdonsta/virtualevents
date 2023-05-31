<?php

namespace App\Mail;

use App\Models\EventEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEventInvitation extends Mailable
{
    use Queueable, SerializesModels;

    private EventEmail $eventEmail;
    private User $user;
    private string $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EventEmail $eventEmail, User $user, string $content = '')
    {
        $this->eventEmail = $eventEmail;
        $this->user = $user;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->markdown(
            'backend.emails.templates.invitation',
            [
                'user' => $this->user,
                'eventEmail' => $this->eventEmail,
                'content' => $this->content
            ]
        )
            ->from($this->eventEmail->email_address, $this->eventEmail->sender)
            ->replyTo($this->eventEmail->reply_to, $this->eventEmail->sender)
            ->subject($this->eventEmail->subject);
    }
}
