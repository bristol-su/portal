<?php


namespace App\Http\Views;


use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\Support\Settings\SettingRepository;
use BristolSU\Support\User\Contracts\UserAuthentication;
use Illuminate\Contracts\View\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class InjectSettings
{

    /**
     * @var SettingRepository
     */
    private SettingRepository $settingRepository;
    /**
     * @var UserAuthentication
     */
    private UserAuthentication $userAuthentication;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(SettingRepository $settingRepository, UserAuthentication $userAuthentication, UserRepository $userRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->userAuthentication = $userAuthentication;
        $this->userRepository = $userRepository;
    }

    public function compose(View $view)
    {
        JavaScriptFacade::put([
            'site_settings' => $this->settingRepository->all(),
            'APP_URL' => config('app.url'),
            'API_URL' => config('app.api_url')
        ]);
    }

}
