<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Queues;
use App\Enums\VerificationTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetAdminPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Jobs\SendResetPasswordMail;
use App\Models\Admin;
use App\Models\Token;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
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

class AdminController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'guest:admin',
        ])->except('logout');
    }

    /**
     * @return Guard|StatefulGuard
     */
    public function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  Request  $request
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
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function showLoginForm(Request $request)
    {
        return view('auth.index', [
            'guard' => 'admin',
            'screen' => 'login',
            'title' => trans('dashboard.login'),
            'redirect' => $request->input('redirect', ''),
        ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse|RedirectResponse|mixed
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'user' => $this->guard()->user(),
            ]);
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectTo);
    }

    /**
     * @param  Request  $request
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect(route('auth.show_admin_login_form'));
    }

    /**
     * @return Factory|View
     */
    public function showForgetPasswordForm()
    {
        return view('auth.index', [
            'guard' => 'admin',
            'screen' => 'forget',
            'title' => trans('dashboard.forget_password'),
        ]);
    }

    /**
     * @param  ForgetAdminPasswordRequest  $request
     * @return JsonResponse|void
     */
    public function createResetPasswordToken(ForgetAdminPasswordRequest $request)
    {
        try {
            $admin = Admin::whereEmail($request->input('email'))->first();
            $token = new Token([
                'admin_id' => $admin->id,
                'expired_at' => now()->addHours(3),
                'token' => Str::random(20).uniqid(),
                'verification_type' => VerificationTypes::RESET_PASSWORD,
            ]);
            $token->save();
            SendResetPasswordMail::dispatch($token, $admin, 'admin')->onQueue(Queues::HIGH);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        abort(404);
    }

    /**
     * @param  Token  $token
     * @return Factory|View
     */
    public function showResetPasswordForm(Token $token)
    {
        if ($token->isExpired()
            || $token->verification_type !== VerificationTypes::RESET_PASSWORD
            || $token->admin_id === null
        ) {
            abort(403);
        }

        return view('auth.index', [
            'guard' => 'admin',
            'screen' => 'reset',
            'token' => $token->token,
            'title' => trans('dashboard.reset_password'),
            'redirect' => route('admin.index'),
        ]);
    }

    /**
     * @param  Token  $token
     * @param  ResetPasswordRequest  $request
     * @return RedirectResponse|Redirector
     */
    public function resetPassword(Token $token, ResetPasswordRequest $request)
    {
        if ($token->isExpired()
            || $token->verification_type !== VerificationTypes::RESET_PASSWORD
            || $token->admin_id === null
        ) {
            abort(403);
        }

        $admin = $token->admin()->first();

        DB::transaction(function () use ($admin, $request, $token) {
            $admin->update($request->parameters());
            $token->delete();
        });

        $this->guard()->login($admin);

        return redirect(route('admin.index'));
    }
}
