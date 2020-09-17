<?php


namespace App\Http\View\Utilities;


use App\Support\Settings\SettingRepository;
use Illuminate\Contracts\View\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class JavascriptComposer
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
            'APP_URL' => config('app.url'),
            'API_URL' => config('app.api_url'),
            'siteSettings' => $this->settingRepository->all()
        ]);
    }
}
