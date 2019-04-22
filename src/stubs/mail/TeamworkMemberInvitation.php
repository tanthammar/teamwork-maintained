<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mpociot\Teamwork\TeamInvite as Invite;

class TeamworkMemberInvitation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The invitation instance.
     *
     * @var Invite
     */
    public $invite;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
        $this->url = route('teams.accept_invite', $invite->accept_token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation to join team: ' . $this->invite->team->name)
            ->markdown('teamwork.emails.invitation');
    }
}
