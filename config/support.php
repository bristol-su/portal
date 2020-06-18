<?php

return [
    'analytics' => [
        'enabled' => env('ANALYTICS_ENABLED', false)
    ],
    'revision' => [
        'cleanup' => [
            'enabled' => env('REVISION_CLEANUP_ENABLED', true),
            'limit' => env('REVISION_CLEANUP_LIMIT', 10000)
        ]
    ],
    'caching' => [
        'filters' => [
            'enabled' => env('FILTER_CACHING_ENABLED', true)
        ]
    ],
    'progress' => [
        'default' => 'database',
        'export' => [
            'database' => [
                'driver' => 'database'
            ],
            'portal-airtable' => [
                'driver' => 'airtable',
                'debug' => true,
                'baseId' => 'applpYkQ4NQFAw2YK',
                'tableName' => 'Progress',
                'apiKey' => env('AIRTABLE_API_KEY')
            ]
        ]
    ]
];
