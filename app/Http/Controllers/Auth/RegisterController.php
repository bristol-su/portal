<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserVerificationRequestGenerated;
use App\Http\Controllers\Controller;
use App\Support\Settings\SettingRepository;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as ControlUserRepository;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\User\Contracts\UserRepository as DatabaseUserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

/**
 * Handle registration of a user
 */
class RegisterController extends Controller
{

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Create a new controller instance.
     *
     * - Apply the guest middleware
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Register the user.
     *
     * This registration method is only for standard registration, not single sign on.
     *
     * - Find them with the DataUser Repository.
     * - Find them on control, or create them if not found.
     * - Create a database user.
     * - Login to the database user.
     *
     * @param Request $request
     * @param SettingRepository $settingRepository
     * @param DataUserRepository $dataUserRepository
     * @param ControlUserRepository $controlUserRepository
     * @param DatabaseUserRepository $databaseUserRepository
     * @param UserAuthentication $databaseUserAuthentication
     * @return RedirectResponse|Redirector
     */
    public function register(Request $request,
                             SettingRepository $settingRepository,
                             DataUserRepository $dataUserRepository,
                             ControlUserRepository $controlUserRepository,
                             DatabaseUserRepository $databaseUserRepository,
                             UserAuthentication $databaseUserAuthentication)
    {


        $shouldAlreadyBeInData = $settingRepository->get('authentication.authorization.requiredAlreadyInData', false);
        $shouldAlreadyBeInControl = $settingRepository->get('authentication.authorization.requiredAlreadyInControl', false);
        $emailShouldBeVerified = $settingRepository->get('authentication.verification.required', false);

        $identifierValidation = $settingRepository->get('authentication.registration_identifier.validation', '');
        $identifier = $settingRepository->get('authentication.registration_identifier.identifier', 'email');
        $identifierValue = $request->input('identifier');

        $passwordValidation = $settingRepository->get('authentication.password.validation', 'required|confirmed|min:6');

        $notInDataExceptionMessage = $settingRepository->get('authentication.messages.notInData',
            'We didn\'t recognise your details. Please create an account on our website.');
        $notInControlExceptionMessage = $settingRepository->get('authentication.messages.notInControl',
            'You aren\'t currently registered in our systems. Please contact us.');
        $alreadyRegisteredExceptionMessage = $settingRepository->get('authentication.messages.alreadyRegistered',
            'You have already registered!');


        $request->validate([
            'identifier' => $identifierValidation,
            'password' => $passwordValidation
        ]);


        // Get the data user
        try {
            $dataUser = $dataUserRepository->getWhere([$identifier => $identifierValue]);
        } catch (Exception $e) {
            if ($shouldAlreadyBeInData) {
                return back()
                    ->withErrors(['identifier' => $notInDataExceptionMessage])
                    ->withInput();
            } else {
                $dataUser = $dataUserRepository->create();
                if ($identifier === 'email') {
                    $dataUser->setEmail($identifierValue);
                } else {
                    $dataUser->setAdditionalAttribute($identifier, $identifierValue);
                }
            }

        }


        // Find them in control, or create them
        try {
            $controlUser = $controlUserRepository->getByDataProviderId($dataUser->id());
        } catch (ModelNotFoundException $e) {
            if ($shouldAlreadyBeInControl) {
                return back()
                    ->withErrors(['identifier' => $notInControlExceptionMessage])
                    ->withInput();
            } else {
                $controlUser = $controlUserRepository->create($dataUser->id());
            }
        }

        // Create database user if they don't exist
        try {
            $databaseUserRepository->getFromControlId($controlUser->id());
            return back()
                ->withErrors(['identifier' => $alreadyRegisteredExceptionMessage])
                ->withInput();
        } catch (ModelNotFoundException $e) {
        }

        $user = $databaseUserRepository->create(['control_id' => $controlUser->id()]);
        $user->password = Hash::make($request->input('password'));
        if (!$emailShouldBeVerified) {
            $user->email_verified_at = Carbon::now();
        }
        $user->save();

        event(new UserVerificationRequestGenerated($user));

        $databaseUserAuthentication->setUser($user);

        return redirect('welcome');
    }

}
