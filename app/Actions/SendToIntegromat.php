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
            Field::textInput('webhook_url')->setLabel('Webhook URL')
                ->setRequired(true)->setValue('')->setHint('This is the URL Integromat will give you.')
                ->setTooltip('We need to know which Scenario to trigger. Start by setting up your scenario, and choose the Webhook trigger. This should give you a URL, which you should paste in here')
        )->withGroup(
            Group::make('Data')->withField(
                Field::textInput('data_one')->setLabel('Data #1')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_two')->setLabel('Data #2')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_three')->setLabel('Data #3')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_four')->setLabel('Data #4')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_five')->setLabel('Data #5')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_six')->setLabel('Data #6')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_seven')->setLabel('Data #7')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_eight')->setLabel('Data #8')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_nine')->setLabel('Data #9')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_ten')->setLabel('Data #10')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_eleven')->setLabel('Data #11')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_twelve')->setLabel('Data #12')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_thirteen')->setLabel('Data #13')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_fourteen')->setLabel('Data #14')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )->withField(
                Field::textInput('data_fifteen')->setLabel('Data #15')->setRequired(false)->setValue(null)->setHint('This data will be passed to Integromat')
            )
        )->getSchema();
    }
}
