<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BristolSU\Support\User\Contracts\UserRepository;
use BristolSU\Support\User\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/portal';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param Request $request
     * @param null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function showResetForm(Request $request, $token = null)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $identifier = $this->getIdentifierFromEmail($request->input('email'));

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'identifier' => $identifier]
        );
    }

    /**
     * Get a user identifier from their email address
     *
     * @param string $email
     * @return string Value of their identifier
     * @throws AuthorizationException
     */
    protected function getIdentifierFromEmail(string $email)
    {
        if(siteSetting('authentication.registration_identifier.identifier', 'email') === 'email') {
            return $email;
        } else {
            try {
                $user = app(UserRepository::class)->getWhereEmail($email);
                return $user->controlUser()->data()->getAdditionalAttribute(
                    siteSetting('authentication.registration_identifier.identifier', 'email')
                );
            } catch (ModelNotFoundException $e) {
                throw new AuthorizationException;
            }
        }
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'identifier' => siteSetting('authentication.registration_identifier.validation', ''),
            'password' => siteSetting('authentication.password.validation', 'required|confirmed|min:6')
        ];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'identifier', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('identifier'))
            ->withErrors(['identifier' => trans($response)]);
    }

}
