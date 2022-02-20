<?php

namespace App\Observers;

use App\Enums\Queues;
use App\Enums\VerificationTypes;
use App\Jobs\SendVerificationMail;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{

	/**
	 * Handle the user "created" event.
	 *
	 * @param User $user
	 *
	 * @return void
	 */
	public function created(User $user)
	{
		$token = new Token([
			'user_id' => $user->id,
			'expired_at' => date('Y-m-d H:i:s', strtotime('+1 days')),
			'token' => Str::random(20) . uniqid(),
			'verification_type' => VerificationTypes::EMAIL,
		]);
		$token->save();
		SendVerificationMail::dispatch($user, $token)->onQueue(Queues::HIGH);
	}
}
