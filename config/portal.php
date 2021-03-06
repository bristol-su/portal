<?php

return [
    /*
     * During reaffiliation, we show Mandatory, Optional and Complete headers (along with non-reaffiliation ones
     *      as normal). After reaffiliation, switch to normal headers
     */
    'headers' => [
        'default' => [
            'header' => 'Additional Tasks',
            'subtitle' => 'Some other features to help you run your group',
        ],
        'reaffiliation-mandatory' => [
            'header' => 'Reaffiliation - Mandatory',
            'subtitle' => 'Mandatory reaffiliation tasks to be completed in order to reaffiliate.',
        ],
        'reaffiliation-optional' => [
            'header' => 'Reaffiliation - Optional',
            'subtitle' => 'Optional reaffiliation tasks to help your group throughout the year.',
        ],
        'we-are-bristol' => [
            'header' => '#WeAreBristol',
            'subtitle' => 'We are Bristol Registration',
        ],

        'reaffiliation-complete' => [
            'header' => 'Completed Reaffiliation Tasks',
            'subtitle' => 'These are all the tasks needed for reaffiliation which your group has finished!',
            'always-show' => true,
        ],

        // Admin Headers
        'financial' => [
            'header' => 'Finance',
            'subtitle' => 'Financial Information'
        ],
        'committee-details' => [
            'header' => 'Committee',
            'subtitle' => 'Committee information'
        ],
        'documents' => [
            'header' => 'Documents',
            'subtitle' => 'Documents requiring approval.'
        ],
        'statements' => [
            'header' => 'Statements',
            'subtitle' => 'Statements from groups.'
        ],
        'assets' => [
            'header' => 'Assets',
            'subtitle' => 'Information about assets of groups.'
        ],
        'group-info' => [
            'header' => 'Groups',
            'subtitle' => 'Group Information'
        ],
        'stats' => [
            'header' => 'Reaffiliation Progress',
            'subtitle' => 'Track group progress through reaffiliation'
        ]

    ],

    'header_information_gates' => [
        'visible' => 'module.isVisible',
        'active' => 'module.isActive',
        'responsible' => 'reaffiliation.isResponsible',
        'mandatory' => 'reaffiliation.isMandatory',
    ],

    'reaffiliation_year' => (int)env('REAFFILIATION_YEAR', 2017),

    'we_are_bristol' => [
        'enabled' => env('WE_ARE_BRISTOL_ENABLED', false)
    ],

    // TODO Is there another way?
    'exec_committee' => [
        5, 22, 23
    ],

    'position_grouping' => [
        'presidents' => [5, 22, 23],
        'treasurers' => [6]
    ],


    'module_order' => [
        'PresidentHandover',
        'GroupInfo',
        'CommitteeDetails',
        'TaskAllocation',
        'MainContacts',
        'ExitingTreasurer',
        'Constitution',
        'RiskAssessment',
        'EquipmentList',
        'IncomingTreasurer',
        'ExternalAccounts',
        'Safeguarding',
        'GDPR',
        'NGB',
        'CharitableGiving',
        'LibelDefamation',
        'PoliticalActivity',
        'StrategicPlan',
        'Budget',
        'TierSelection',
        'FurtherInformation',
        'ExecutiveSummary',
        'WABBudget',
        'WABStrategicPlan',
        'Presentation'
    ],

    'header_order' => [
        'reaffiliation-complete',
        'reaffiliation-mandatory',
        'reaffiliation-optional',
        'we-are-bristol'
    ],

    'knowledge_base' => [
        'url' => 'https://bristolsu.freshdesk.com/support/solutions/'
    ]

];