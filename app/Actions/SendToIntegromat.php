<?php

namespace App\Actions;

use BristolSU\Support\Action\Contracts\Action;

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
        // TODO: Implement handle() method.
    }

    /**
     * @inheritDoc
     */
    public function getFields(): array
    {
        return [
            'data_one' => $this->data['one'],
            'data_two' => $this->data['two'],
            'data_three' => $this->data['three'],
            'data_four' => $this->data['four'],
            'data_five' => $this->data['five'],
            'data_six' => $this->data['six'],
            'data_seven' => $this->data['seven'],
            'data_eight' => $this->data['eight'],
            'data_nine' => $this->data['nine'],
            'data_ten' => $this->data['ten'],
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getFieldMetaData(): array
    {
        return [
            'data_one' => [
                'label' => 'Data One',
                'helptext' => 'The first bit of data'
            ],
            'data_two' => [
                'label' => 'Data Two',
                'helptext' => 'The second bit of data'
            ],
            'data_three' => [
                'label' => 'Data Three',
                'helptext' => 'The third bit of data'
            ],
            'data_four' => [
                'label' => 'Data Four',
                'helptext' => 'The fourth bit of data'
            ],
            'data_five' => [
                'label' => 'Data Five',
                'helptext' => 'The fifth bit of data'
            ],
            'data_six' => [
                'label' => 'Data Six',
                'helptext' => 'The sixth bit of data'
            ],
            'data_seven' => [
                'label' => 'Data Seven',
                'helptext' => 'The seventh bit of data'
            ],
            'data_eight' => [
                'label' => 'Data Eight',
                'helptext' => 'The eighth bit of data'
            ],
            'data_nine' => [
                'label' => 'Data Nine',
                'helptext' => 'The ninth bit of data'
            ],
            'data_ten' => [
                'label' => 'Data Ten',
                'helptext' => 'The tenth bit of data'
            ]
        ];
    }
}
