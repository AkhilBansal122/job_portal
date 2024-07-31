<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function build()
    {
        return $this->view('emails.sendOtp')
            ->subject('Welcome to ' . config('app.name'))
            ->with([
                'userName' => $this->user->name,
            ]);
    }
}
