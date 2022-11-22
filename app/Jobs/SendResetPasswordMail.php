<?php

namespace App\Jobs;

use App\Mail\EmailResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordMail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $token;

    protected $user;

    protected $guard;

    /**
     * Create a new job instance.
     *
     * @param $token
     * @param $user
     * @param  string  $guard
     */
    public function __construct($token, $user, $guard = 'user')
    {
        $this->token = $token;
        $this->user = $user;
        $this->guard = $guard;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new EmailResetPassword($this->token, $this->user, $this->guard));
    }
}
