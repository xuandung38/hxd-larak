<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Queues;
use App\Enums\VerificationTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetUserPasswordRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Jobs\SendResetPasswordMail;
use App\Models\Token;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
	use AuthenticatesUsers;

	protected $userService;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */

	protected $redirectTo = '/message';


	/**
	 * Create a new controller instance.
	 *
	 * @param UserService $userService
	 */

	public function __construct(UserService $userService)
	{
		$this->middleware([
			'guest:user',
		])->except('logout');

		$this->userService = $userService;
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		$field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
			? $this->username()
			: 'username';
		return [
			$field => $request->get($this->username()),
			'password' => $request->password,
		];
	}

	/**
	 * @param Request $request
	 *
	 * @return Factory|View
	 */
	public function showLoginForm(Request $request)
	{
		return view('auth.index', [
			'guard' => 'user',
			'screen' => 'login',
			'title' => trans('dashboard.login'),
			'redirect' => $request->input('redirect', '')
		]);
	}

	public function login(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if (method_exists($this, 'hasTooManyLoginAttempts') &&
			$this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($this->attemptLogin($request)) {
			$user = $this->guard()->user();

			if (!$user->hasVerifiedEmail()) {
				$this->guard()->logout();
				$request->session()->invalidate();
				$request->session()->regenerateToken();

				return response(json_encode([
					'error' => 'Vui lòng xác thực tài khoản bằng email.',
					'csrf_token' => csrf_token()
				]), 422);
			}

			if ($request->hasSession()) {
				$request->session()->put('auth.password_confirmed_at', time());
			}
			$user->update([
				'last_login' => today()
			]);

			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * @return mixed
	 */
	public function guard()
	{
		return Auth::guard('user');
	}

	/**
	 * @param Request $request
	 *
	 * @return Response
	 */
	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

		$this->clearLoginAttempts($request);

		if ($request->ajax() || $request->wantsJson()) {
			return response()->json(['success' => true]);
		}

		return $this->authenticated($request, $this->guard()->user())
			?: redirect()->intended($this->redirectPath());
	}

	/**
	 * @param Request $request
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return $this->loggedOut($request) ?: redirect(route('index'));
	}

	/**
	 * @return Factory|View
	 */
	public function showRegisterForm()
	{
		return view('auth.index', [
			'guard' => 'user',
			'screen' => 'register',
			'title' => trans('dashboard.register')
		]);
	}

	/**
	 * @param RegisterUserRequest $request
	 * @param UserService         $userService
	 *
	 * @return JsonResponse
	 */
	public function registerUser(RegisterUserRequest $request, UserService $userService)
	{
		$user = $userService->createUser($request->parameters());
		// $this->guard()->login($user);

		return response()->json([
			'success' => true,
			'user' => $user,
		]);
	}


	/**
	 * @return Factory|View
	 */
	public function showForgetPasswordForm()
	{
		return view('auth.index', [
			'guard' => 'user',
			'screen' => 'forget',
			'title' => trans('dashboard.forget_password')
		]);
	}

	/**
	 * @param ForgetUserPasswordRequest $request
	 *
	 * @return JsonResponse|void
	 */
	public function createResetPasswordToken(ForgetUserPasswordRequest $request)
	{
		try {
			$user = User::whereEmail($request->input('email'))->first();
			$token = new Token([
				'user_id' => $user->id,
				'expired_at' => now()->addHours(3),
				'token' => Str::random(20) . uniqid(),
				'verification_type' => VerificationTypes::RESET_PASSWORD,
			]);
			$token->save();
			SendResetPasswordMail::dispatch($token, $user, 'user')->onQueue(Queues::HIGH);

			return response()->json(['success' => true]);
		} catch (Exception $e) {
			Log::error($e->getMessage());
		}

		abort(404);
	}

	/**
	 * @param Token $token
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function verifyEmail(Token $token)
	{
		if ($token->isExpired() || $token->verification_type !== VerificationTypes::EMAIL) {
			abort(403);
		}

		$user = $token->user()->first();

		if ($user === null) {
			abort(404);
		}

		$user->email_verified_at = now();
		$user->save();
		$this->guard()->login($user);

		return redirect(route('index'));
	}

	/**
	 * @param Token $token
	 *
	 * @return Factory|View
	 */
	public function showResetPasswordForm(Token $token)
	{
		if ($token->isExpired() || $token->verification_type !== VerificationTypes::RESET_PASSWORD) {
			abort(403);
		}

		return view('auth.index', [
			'guard' => 'user',
			'screen' => 'reset',
			'token' => $token->token,
			'title' => trans('dashboard.reset_password')
		]);
	}

	/**
	 * @param Token                $token
	 * @param ResetPasswordRequest $request
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function resetPassword(Token $token, ResetPasswordRequest $request)
	{
		if ($token->isExpired()
			|| $token->verification_type !== VerificationTypes::RESET_PASSWORD
			|| $token->user_id === null
		) {
			abort(403);
		}

		$user = $token->user()->first();

		DB::transaction(function () use ($user, $request, $token) {
			$user->update($request->parameters());
			$token->delete();
		});

		$this->guard()->login($user);

		return redirect(route('index'));
	}

}
