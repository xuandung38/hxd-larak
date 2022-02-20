<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request     $request
	 * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @param string|null ...$guards
	 *
	 * @return Response|RedirectResponse
	 */
	public function handle(Request $request, Closure $next, ...$guards)
	{
		$guards = empty($guards) ? [null] : $guards;

		foreach ($guards as $guard) {
			if ($guard === "admin" && Auth::guard($guard)->check()) {
				return redirect(route('admin.index'));
			}

			if ($guard === "user" && Auth::guard($guard)->check()) {
				return redirect(route('user.messages_inbox'));
			}
		}

        return $next($request);
    }
}
