<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserVerificationRequestGenerated;
use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as ControlUserRepository;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\User\Contracts\UserRepository as DatabaseUserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Handle registration of a user
 */
class RegisterController extends Controller
{
    use RegistersUsers;

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
     * Register the user
     *
     * - Find them with the DataUser Repository.
     * - Find them on control, or create them if not found.
     * - Create a database user
     * - Login to the database user
     *
     * @param Request $request
     * @param ControlUserRepository $controlUserRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request,
                             DataUserRepository $dataUserRepository,
                             ControlUserRepository $controlUserRepository,
                             DatabaseUserRepository $databaseUserRepository,
                             UserAuthentication $databaseUserAuthentication)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => 'required|confirmed|min:6'
        ]);

        // Find a DataUser
        try {
            $dataUser = $dataUserRepository->getWhere(['email' => $request->input('email')]);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['email' => 'We didn\'t recognise your email address. Please create an account on our website.'])
                ->withInput();
        }

        // Find them in control, or create them
        try {
            $controlUser = $controlUserRepository->getByDataProviderId($dataUser->id());
        } catch (ModelNotFoundException $e) {
            $controlUser = $controlUserRepository->create($dataUser->id());
        }

        // Create database user
        $user = $databaseUserRepository->create([
            'forename' => $dataUser->firstName(),
            'surname' => $dataUser->lastName(),
            'email' => $dataUser->email(),
            'control_id' => $controlUser->id()
        ]);

        $user->password = Hash::make($request->input('password'));
        $user->email_verified_at = Carbon::now();
        $user->save();

        event(new UserVerificationRequestGenerated($user));

        $databaseUserAuthentication->setUser($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());

    }

    /**
     * Redirect the user
     *
     * @return string
     */
    public function redirectTo()
    {
        return 'portal';
    }


}
