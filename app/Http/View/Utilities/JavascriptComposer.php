<?php


namespace App\Http\View\Utilities;


use App\Support\Settings\SettingRepository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Contracts\View\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class JavascriptComposer
{
    /**
     * @var SettingRepository
     */
    private SettingRepository $settingRepository;
    /**
     * @var Authentication
     */
    private Authentication $authentication;

    public function __construct(SettingRepository $settingRepository, Authentication $authentication)
    {
        $this->settingRepository = $settingRepository;
        $this->authentication = $authentication;
    }

    public function compose(View $view)
    {
        JavaScriptFacade::put([
            'APP_URL' => config('app.url'),
            'API_URL' => config('app.api_url'),
            'siteSettings' => $this->settingRepository->all(),
            'user' => $this->authentication->getUser(),
            'group' => $this->authentication->getGroup(),
            'role' => $this->authentication->getRole(),
        ]);
    }
}
