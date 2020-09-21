<?php


namespace App\Http\View\Utilities;


use App\Support\Settings\SettingRepository;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\ActivityInstance\Exceptions\NotInActivityInstanceException;
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
    /**
     * @var ActivityInstanceResolver
     */
    private ActivityInstanceResolver $activityInstanceResolver;

    public function __construct(SettingRepository $settingRepository, Authentication $authentication, ActivityInstanceResolver $activityInstanceResolver)
    {
        $this->settingRepository = $settingRepository;
        $this->authentication = $authentication;
        $this->activityInstanceResolver = $activityInstanceResolver;
    }

    public function compose(View $view)
    {
        try {
            $activityInstance = $this->activityInstanceResolver->getActivityInstance();
        } catch(NotInActivityInstanceException $e) {
            $activityInstance = null;
        }
        JavaScriptFacade::put([
            'APP_URL' => config('app.url'),
            'API_URL' => config('app.api_url'),
            'siteSettings' => $this->settingRepository->all(),
            'user' => $this->authentication->getUser(),
            'group' => $this->authentication->getGroup(),
            'role' => $this->authentication->getRole(),
            'activity_instance' => $activityInstance
        ]);
    }
}
