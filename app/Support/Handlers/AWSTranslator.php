<?php

namespace App\Support\Handlers;

use Aws\Exception\AwsException;
use Aws\Sts\StsClient;
use Aws\Translate\TranslateClient;
use BristolSU\Support\Translation\Translate\Handler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class AWSTranslator extends Handler
{

    public function translate(string $line, string $lang): string
    {
        $config = [
            'version' => $this->getConfig('version'),
            'region' => $this->getConfig('region')
        ];

        if ($this->getConfig('credentials.key', null) !== null && $this->getConfig('credentials.secret', null) !== null) {
            $config['credentials'] = Arr::only($this->getConfig('credentials'), ['key', 'secret', 'token']);
        }

        $client = new TranslateClient($config);

        $currentLanguage = 'en';


        try {
            $result = $client->translateText([
                'SourceLanguageCode' => $currentLanguage,
                'TargetLanguageCode' => $lang,
                'Text' => $line,
            ]);
            if($result->hasKey('TranslatedText')) {
                return $result->get('TranslatedText');
            }
        }catch (AwsException $e) {
            Log::info($e->getMessage());
        }
        return $line;
    }
}
