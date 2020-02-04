<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\User\Contracts\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
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
     * Show the application's login form.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($provider)
    {
        if(in_array($provider, siteSetting('thirdPartyAuthentication.providers', []))) {
            return Socialite::driver($provider)->redirect();
        }
        return redirect()->route('login')
            ->withErrors(['identifier' => 'You cannot log in through ' . $provider]);
    }

    public function handleCallback($provider)
    {

        $shouldAlreadyBeInData = siteSetting('authentication.authorization.requiredAlreadyInData', false);
        $shouldAlreadyBeInControl = siteSetting('authentication.authorization.requiredAlreadyInControl', false);

        $notInDataExceptionMessage = siteSetting('authentication.messages.notInData',
            'We didn\'t recognise your details. Please create an account on our website.');
        $notInControlExceptionMessage = siteSetting('authentication.messages.notInControl',
            'You aren\'t currently registered in our systems. Please contact us.');

        $user = Socialite::driver($provider)->user();

        try {
            $dataUser = app(DataUser::class)->getWhere(['email' => $user->getEmail()]);
        } catch (ModelNotFoundException $e) {
            if ($shouldAlreadyBeInData) {
                return redirect()->route('login')
                    ->withErrors(['identifier' => $notInDataExceptionMessage]);
            } else {
                $dataUser = app(DataUser::class)->create($user->getName(), null, $user->getEmail(), null, $user->getNickname());
            }

        }


        // Find them in control, or create them
        try {
            $controlUser = app(User::class)->getByDataProviderId($dataUser->id());
        } catch (ModelNotFoundException $e) {
            if ($shouldAlreadyBeInControl) {
                return redirect()->route('login')
                    ->withErrors(['identifier' => $notInControlExceptionMessage]);
            } else {
                $controlUser = app(User::class)->create($dataUser->id());
            }
        }

        // Create database user if they don't exist
        $hasRegistered = false;
        try {
            $databaseUser = app(UserRepository::class)->getFromControlId($controlUser->id());
        } catch (ModelNotFoundException $e) {
            $databaseUser = app(UserRepository::class)->create(['control_id' => $controlUser->id()]);
            $databaseUser->email_verified_at = Carbon::now();
            $databaseUser->save();
            $hasRegistered = true;
        }

        app(UserAuthentication::class)->setUser($databaseUser);

        return ($hasRegistered?redirect('welcome'):redirect('portal'));

    }

}
