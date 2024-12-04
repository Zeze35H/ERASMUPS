<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordRecovery extends Mailable
{
    use Queueable, SerializesModels;



    public $token;

    /**
     * Create a new message instance.
     * @param  \App\Models\User  $user
     * @param int $code code to reset password
     * @return void
     */
    public function __construct(String $token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ERASMUPS Password Recovery')
                    ->view('emails.recover_password');
    }
}
