<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_KEY'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI')
    ],

    /*
    |--------------------------------------------------------------------------
    | tansik.digital.gov.eg coordination limit importer (HTTP)
    |--------------------------------------------------------------------------
    |
    | Laravel's HTTP client defaults connect_timeout to 10s; slow TLS/handshake
    | from some hosts to the ministry site can hit that before transfer starts.
    |
    | force_ipv4: many hosts resolve AAAA first; if the IPv6 route is broken you
    | get connect timeouts until connect_timeout elapses (set false only if needed).
    |
    | http_proxy: Guzzle proxy URL when production cannot egress directly (e.g.
    | http://user:pass@host:8123 or socks5h://127.0.0.1:9050).
    |
    | limits_dir: directory of Limit*.htm files (from tansik:pull-government-coordination-limits)
    | when the app host cannot open TCP to tansik.digital.gov.eg at all.
    |
    */
    'tansik_digital_gov_import' => [
        'http_timeout' => (int) env('TANSIK_DIGITAL_GOV_IMPORT_HTTP_TIMEOUT', 120),
        'http_connect_timeout' => (int) env('TANSIK_DIGITAL_GOV_IMPORT_HTTP_CONNECT_TIMEOUT', 60),
        'force_ipv4' => filter_var(env('TANSIK_DIGITAL_GOV_IMPORT_FORCE_IPV4', true), FILTER_VALIDATE_BOOLEAN),
        'http_proxy' => env('TANSIK_DIGITAL_GOV_IMPORT_HTTP_PROXY') ?: null,
        'limits_dir' => env('TANSIK_DIGITAL_GOV_IMPORT_LIMITS_DIR') ?: null,
    ],

];
