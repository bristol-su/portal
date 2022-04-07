<?php

return [
    'api_prefix' => env('CONTROL_API_PREFIX', '/api/control'),
    'api_middleware' => [
        'api',
        'can:access-control'
    ],

    'logicId' => env('COMMITTEE_CONTACT_DETAILS_LOGIC_ID'),

    'logicIdTwo' => env('COMMITTEE_CONTACT_DETAILS_LOGIC_ID_TWO'),

    'export' => [

        /*
        |--------------------------------------------------------------------------
        | Default Export Method
        |--------------------------------------------------------------------------
        |
        | This option defines the default export method for exporting control data.
        | The name specified in this option should match one of the configuration options
        | listed below.
        |
        */
        'default' => 'contact-details',

        /*
        |--------------------------------------------------------------------------
        | Log Channels
        |--------------------------------------------------------------------------
        |
        | Here you may configure the export drivers for control. Each option must
        | reference a driver to use, and may additionally register any formatters
        | or configuration for that driver.
        |
        | Available Drivers:
        |     - save-csv     Save a csv to a given disk system
        |     - dump     Dump the results using the symfony dumper
        |
        */

        'bristol-control-users' => [
            'driver' => 'airtable',
            'debug' => false,
            'formatters' => [
                \App\Exports\FilterUsersWhoHaveRole::class => [],
                \BristolSU\ControlDB\Export\Formatter\User\SimpleUserFormatter::class => [],
                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
                    'column' => 'User Last Name'
                ],
            ],
            'baseId' => env('AIRTABLE_CONTROL_BASE_ID'),
            'tableName' => 'Users',
            'apiKey' => env('AIRTABLE_API_KEY'),
            'uniqueIdColumnName' => ['User ID']
        ],

        'bristol-control-positions' => [
            'driver' => 'airtable',
            'debug' => false,
            'formatters' => [
                \App\Exports\SimplePositionFormatter::class => [],
                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
                    'column' => 'Position Name'
                ],
            ],
            'baseId' => env('AIRTABLE_CONTROL_BASE_ID'),
            'tableName' => 'Positions',
            'apiKey' => env('AIRTABLE_API_KEY'),
            'uniqueIdColumnName' => ['Position ID']
        ],

        'bristol-control-groups' => [
            'driver' => 'airtable',
            'debug' => false,
            'formatters' => [
                \BristolSU\ControlDB\Export\Formatter\Group\SimpleGroupFormatter::class => [],
                \App\Exports\IsGroupDisaffiliated::class => [
                    'disaffiliatingTagId' => env('DISAFFILIATING_TAG_ID')
                ],
                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
                    'column' => 'Group Name'
                ],
                \App\Exports\AddGroupExecCommittee::class => [
                    'president_positions' => [23,5,22],
                    'treasurer_positions' => [6],
                    'secretary_positions' => [7]
                ],
            ],
            'baseId' => env('AIRTABLE_CONTROL_BASE_ID'),
            'tableName' => 'Groups',
            'apiKey' => env('AIRTABLE_API_KEY'),
            'uniqueIdColumnName' => ['Group ID']
        ],

        'bristol-control-roles' => [
            'driver' => 'airtable',
            'debug' => false,
            'formatters' => [
                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
                \App\Exports\LinkRolesToUsers::class => [],
                \App\Exports\LinkRolesToPosition::class => [],
                \App\Exports\LinkRolesToGroup::class => [],
                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
                    'column' => 'User Last Name'
                ],
                \App\Exports\WrapFieldInArray::class => [
                    'field' => ['Group', 'Position']
                ]
            ],
            'baseId' => env('AIRTABLE_CONTROL_BASE_ID'),
            'tableName' => 'Roles',
            'apiKey' => env('AIRTABLE_API_KEY'),
            'uniqueIdColumnName' => ['Role ID']
        ],

    ]
];
