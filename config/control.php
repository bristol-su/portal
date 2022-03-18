<?php

return [
    'api_prefix' => env('CONTROL_API_PREFIX', '/api/control'),
    'api_middleware' => [
        'api',
        'can:access-control'
    ],

    'logicId' => env('COMMITTEE_CONTACT_DETAILS_LOGIC_ID'),

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
//        'local-roles' => [
//            'driver' => 'save-csv',
//            'formatters' => [
//                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => []
//            ],
//            'disk' => 'local',
//            'filename' => 'export.csv',
//        ],
//
//        'contact-details' => [
//            'driver' => 'save-csv',
//            'formatters' => [
//                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
//                    'column' => 'Group Name'
//                ]
//            ],
//            'disk' => 'local',
//            'filename' => 'contact_details.csv',
//        ],
//
//        'committee-contact-sheet' => [
//            'driver' => 'save-csv',
//            'formatters' => [
//                \App\Exports\FilterRoleByLogicGroupFormatter::class => [
//                    'logicId' => env('COMMITTEE_CONTACT_DETAILS_LOGIC_ID')
//                ],
//                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
//                    'column' => 'Group Name'
//                ]
//            ],
//            'disk' => 'google',
//            'filename' => env('COMMITTEE_CONTACT_DETAILS_FILENAME', 'committee_contact_sheet.csv')
//        ],
//        'committee-contact-sheet-old' => [
//            'driver' => 'save-csv',
//            'formatters' => [
//                \App\Exports\FilterRoleByLogicGroupFormatter::class => [
//                    'logicId' => env('COMMITTEE_CONTACT_DETAILS_OLD_LOGIC_ID')
//                ],
//                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
//                    'column' => 'Group Name'
//                ]
//            ],
//            'disk' => 'google',
//            'filename' => env('COMMITTEE_CONTACT_DETAILS_OLD_FILENAME', 'committee_contact_sheet.csv')
//        ],
//        'committee-contact-sheet-old-old' => [
//            'driver' => 'save-csv',
//            'formatters' => [
//                \App\Exports\FilterRoleByLogicGroupFormatter::class => [
//                    'logicId' => env('COMMITTEE_CONTACT_DETAILS_OLD_OLD_LOGIC_ID')
//                ],
//                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
//                    'column' => 'Group Name'
//                ]
//            ],
//            'disk' => 'google',
//            'filename' => env('COMMITTEE_CONTACT_DETAILS_OLD_OLD_FILENAME', 'committee_contact_sheet.csv')
//        ],
//        'portal-airtable' => [
//            'driver' => 'airtable',
//            'debug' => false,
//            'formatters' => [
//                \App\Exports\FilterRoleByLogicGroupFormatter::class => [
//                    'logicId' => env('COMMITTEE_CONTACT_DETAILS_LOGIC_ID')
//                ],
//                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems::class => [],
//                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
//                    'column' => 'Group Name'
//                ],
//                \App\Exports\WrapFieldInArray::class => [
//                    'field' => 'Group ID'
//                ]
//            ],
//            'baseId' => 'applpYkQ4NQFAw2YK',
//            'tableName' => 'Control',
//            'apiKey' => env('AIRTABLE_API_KEY'),
//            'uniqueIdColumnName' => ['Role ID', 'User ID']
//        ],

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
