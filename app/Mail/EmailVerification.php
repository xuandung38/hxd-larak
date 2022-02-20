<?php

namespace App\Mail;

use App\Models\Token;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $userVerification;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  Token  $userVerification
     */
    public function __construct(User $user, Token $userVerification)
    {
        $this->user = $user;
        $this->userVerification = $userVerification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->view('emails.email_verification', [
		    'user' => $this->user,
		    'userVerification' => $this->userVerification,
	    ])->subject('Xác thực tài khoản - ' . config('app.name'));
    }
}
