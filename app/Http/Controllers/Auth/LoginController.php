<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Settings\SettingRepository;
use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\User\Contracts\UserRepository;
use BristolSU\Support\User\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use ThrottlesLogins;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // Try and get the user from a remember token.
        $user = $this->getUserThroughRememberToken($request);
        // If not, get the user from their credentials
        $user = ($user ?: $this->getUserThroughCredentials($request));

        if($user !== null) {
            app(UserAuthentication::class)->setUser($user);
            return true;
        }
        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return redirect()->intended('/portal');
    }


    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        app(UserAuthentication::class)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'identifier';
    }

    /**
     * Check the remember token in the request is valid
     *
     * @param Request $request Request object
     * @return User|null
     */
    protected function getUserThroughRememberToken(Request $request): ?User
    {
        if($request->has('remember') && is_string($request->input('remember'))) {
            $userRepository = app(UserRepository::class);

            try {
                return $userRepository->getFromRememberToken($request->input('remember'));
            } catch (ModelNotFoundException $e) {}
        }
        return null;
    }

    /**
     * Check the identifier and password are valid
     *
     * @param Request $request Request object
     * @return User|null
     */
    protected function getUserThroughCredentials(Request $request): ?User
    {
        $identifier = app(SettingRepository::class)->get('authentication.registration_identifier.identifier', 'email');
        try {
            $dataUser = app(DataUser::class)->getWhere([$identifier => $request->input($this->username())]);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        try {
            $controlUser = app(\BristolSU\ControlDB\Contracts\Repositories\User::class)->getByDataProviderId($dataUser->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }

        try {
            $user = app(UserRepository::class)->getFromControlId($controlUser->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }

        if(app(Hasher::class)->check($request->input('password'), $user->password)) {
            return $user;
        }
        return null;
    }
}
