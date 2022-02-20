<?php

namespace App\Mail;

use App\Models\Admin;
use App\Models\Token;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;
    protected $guard;

    /**
     * Create a new message instance.
     *
     * @param Token $token
     * @param User|Admin $user
     * @param string $guard
     */
    public function __construct(Token $token, $user, $guard = 'user')
    {
        $this->user = $user;
        $this->token = $token;
        $this->guard = $guard;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->view('emails.reset_password', [
		    'user' => $this->user,
		    'token' => $this->token->token,
		    'guard' => $this->guard,
	    ])->subject('Đặt lại mật khẩu - ' . config('app.name'));
    }
}
