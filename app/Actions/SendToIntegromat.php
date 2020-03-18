<?php

namespace App\Actions;

use BristolSU\Support\Action\Contracts\Action;
use FormSchema\Generator\Field;
use FormSchema\Generator\Group;
use FormSchema\Schema\Form;
use GuzzleHttp\Client;

class SendToIntegromat implements Action
{

    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $client = new Client();
        $client->post($this->data['webhook_url'], [
            'form_params' => [
                'data_one' => $this->getData('data_one'),
                'data_two' => $this->getData('data_two'),
                'data_three' => $this->getData('data_three'),
                'data_four' => $this->getData('data_four'),
                'data_five' => $this->getData('data_five'),
                'data_six' => $this->getData('data_six'),
                'data_seven' => $this->getData('data_seven'),
                'data_eight' => $this->getData('data_eight'),
                'data_nine' => $this->getData('data_nine'),
                'data_ten' => $this->getData('data_ten'),
                'data_eleven' => $this->getData('data_eleven'),
                'data_twelve' => $this->getData('data_twelve'),
                'data_thirteen' => $this->getData('data_thirteen'),
                'data_fourteen' => $this->getData('data_fourteen'),
                'data_fifteen' => $this->getData('data_fifteen')
            ]
        ]);
    }

    private function getData($key) {
        if(array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function options(): Form
    {
        return \FormSchema\Generator\Form::make()->withField(
            Field::input('webhook_url')->inputType('text')->label('Webhook URL')->featured(true)
                ->required(true)->default('')->hint('This is the URL Integromat will give you.')
                ->help('We need to know which Scenario to trigger. Start by setting up your scenario, and choose the Webhook trigger. This should give you a URL, which you should paste in here')
        )->withGroup(
            Group::make('Data')->withField(
                Field::input('data_one')->inputType('text')->label('Data #1')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_two')->inputType('text')->label('Data #2')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_three')->inputType('text')->label('Data #3')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_four')->inputType('text')->label('Data #4')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_five')->inputType('text')->label('Data #5')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_six')->inputType('text')->label('Data #6')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_seven')->inputType('text')->label('Data #7')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_eight')->inputType('text')->label('Data #8')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_nine')->inputType('text')->label('Data #9')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_ten')->inputType('text')->label('Data #10')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_eleven')->inputType('text')->label('Data #11')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_twelve')->inputType('text')->label('Data #12')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_thirteen')->inputType('text')->label('Data #13')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_fourteen')->inputType('text')->label('Data #14')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )->withField(
                Field::input('data_fifteen')->inputType('text')->label('Data #15')->required(false)->default(null)->hint('This data will be passed to Integromat')
            )
        )->getSchema();
    }
}
