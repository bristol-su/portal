<?php

namespace App\Actions;

use BristolSU\Support\Action\ActionResponse;
use BristolSU\Support\Action\Contracts\Action;
use FormSchema\Generator\Field;
use FormSchema\Generator\Group;
use FormSchema\Schema\Form;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SendToIntegromat extends Action
{

    /**
     * @inheritDoc
     */
    public function run(): ActionResponse
    {
        try {
            $client = new Client();
            $client->post($this->option('webhook_url'), [
                'form_params' => [
                    'data_one' => $this->option('data_one'),
                    'data_two' => $this->option('data_two'),
                    'data_three' => $this->option('data_three'),
                    'data_four' => $this->option('data_four'),
                    'data_five' => $this->option('data_five'),
                    'data_six' => $this->option('data_six'),
                    'data_seven' => $this->option('data_seven'),
                    'data_eight' => $this->option('data_eight'),
                    'data_nine' => $this->option('data_nine'),
                    'data_ten' => $this->option('data_ten'),
                    'data_eleven' => $this->option('data_eleven'),
                    'data_twelve' => $this->option('data_twelve'),
                    'data_thirteen' => $this->option('data_thirteen'),
                    'data_fourteen' => $this->option('data_fourteen'),
                    'data_fifteen' => $this->option('data_fifteen')
                ]
            ]);
            return ActionResponse::success('Data sent to Integromat');
        } catch (GuzzleException $e) {
            return ActionResponse::failure($e->getMessage());
        }
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
