<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | Supported: "algolia", "meilisearch", "database", "collection", "null"
    |
    | - database: MySQL/MariaDB full-text on marked columns (good default on prod)
    | - meilisearch: set MEILISEARCH_HOST and run `php artisan scout:import "App\\Models\\Tansik\\University"`
    | - collection: in-memory filter; OK for automated tests / tiny datasets
    |
    */

    'driver' => env('SCOUT_DRIVER', 'database'),

    'prefix' => env('SCOUT_PREFIX', ''),

    'queue' => env('SCOUT_QUEUE', false),

    'after_commit' => false,

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    'soft_delete' => false,

    'identify' => env('SCOUT_IDENTIFY', false),

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://127.0.0.1:7700'),
        'key' => env('MEILISEARCH_KEY', null),
        'index-settings' => [
            'universities' => [
                'filterableAttributes' => ['id', 'is_active', 'slug'],
                'searchableAttributes' => ['name', 'slug', 'type'],
            ],
            'unifac' => [
                'filterableAttributes' => ['id', 'is_active', 'slug', 'university_id'],
                'searchableAttributes' => ['name', 'slug', 'address'],
            ],
        ],
    ],

];
