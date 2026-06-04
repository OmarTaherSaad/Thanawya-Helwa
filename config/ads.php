<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site-wide AdSense (layout slots)
    |--------------------------------------------------------------------------
    |
    | Set ADS_ENABLED=true and ADSENSE_CLIENT (ca-pub-…). Each slot must be the
    | numeric AdSense ad unit ID from your AdSense UI. Empty slot = no markup.
    |
    */

    'enabled' => env('ADS_ENABLED', false),

    /*
    | Publisher ID shown on every <ins class="adsbygoogle">, e.g. ca-pub-1234567890
    */
    'adsense_client' => env('ADSENSE_CLIENT', ''),

    /*
    | Numeric ad unit slot IDs (digits only) per placement.
    */
    'slots' => [
        'sidebar_top' => env('ADSENSE_SLOT_SIDEBAR_TOP', env('ADS_SLOT_SIDEBAR_TOP', '')),
        'in_content' => env('ADSENSE_SLOT_IN_CONTENT', env('ADS_SLOT_IN_CONTENT', '')),
        'footer_banner' => env('ADSENSE_SLOT_FOOTER', env('ADS_SLOT_FOOTER', '')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout / performance
    |--------------------------------------------------------------------------
    |
    | min_heights: reserve space before ads load (reduces CLS). Values are CSS lengths.
    | push_idle_ms: defer AdSense push until the browser is idle (0 = push immediately).
    |
    */

    'min_heights' => [
        'sidebar_top' => env('ADS_MIN_HEIGHT_SIDEBAR_TOP', '120px'),
        'in_content' => env('ADS_MIN_HEIGHT_IN_CONTENT', '120px'),
        'footer_banner' => env('ADS_MIN_HEIGHT_FOOTER', '90px'),
    ],

    'push_idle_ms' => (int) env('ADS_PUSH_IDLE_MS', 800),

];
