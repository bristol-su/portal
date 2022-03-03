<?php


namespace App\Http\View\Utilities;


use Illuminate\Contracts\View\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class JavascriptComposer
{
    public function compose(View $view)
    {
        JavaScriptFacade::put([
            'APP_URL' => config('app.url'),
            'API_URL' => config('app.api_url'),
            'TINY_MCE_KEY' => config('services.tiny_mce.api_key')
        ]);
    }
}
