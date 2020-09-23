<?php


namespace App\Http\Views;


use App\Support\Settings\SettingRepository;
use Illuminate\Contracts\View\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class InjectSettings
{

    /**
     * @var SettingRepository
     */
    private SettingRepository $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function compose(View $view)
    {
        JavaScriptFacade::put([
            'siteSettings' => $this->settingRepository->all(),
            'APP_URL' => config('app.url'),
            'API_URL' => config('app.api_url'),
        ]);
    }

}
