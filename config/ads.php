<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site-wide AdSense (single display unit)
    |--------------------------------------------------------------------------
    |
    | Set ADS_ENABLED=true and ADSENSE_CLIENT (ca-pub-…). Create one Display ad
    | unit in AdSense and put its numeric ID in ADSENSE_SLOT. If empty, no <ins>
    | is rendered (avoids broken placements until the unit exists).
    |
    | Legacy: ADSENSE_SLOT_SIDEBAR_TOP / _IN_CONTENT / _FOOTER are fallbacks when
    | ADSENSE_SLOT is empty (the layout uses the first non-empty numeric value).
    |
    */

    'enabled' => env('ADS_ENABLED', false),

    /*
    | Publisher ID shown on every <ins class="adsbygoogle">, e.g. ca-pub-1234567890
    */
    'adsense_client' => env('ADSENSE_CLIENT', ''),

    /*
    | Single numeric ad unit ID (digits only). Prefer this.
    */
    'slot' => env('ADSENSE_SLOT', ''),

    /*
    | @deprecated Optional fallbacks read in order by the view if "slot" is empty.
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
    | min_height: reserve space before the ad loads (reduces CLS).
    | min_heights: kept for backward compatibility with older env keys.
    | push_idle_ms: defer AdSense push until the browser is idle (0 = push immediately).
    |
    */

    'min_height' => env('ADS_MIN_HEIGHT', '120px'),

    'min_heights' => [
        'sidebar_top' => env('ADS_MIN_HEIGHT_SIDEBAR_TOP', '120px'),
        'in_content' => env('ADS_MIN_HEIGHT_IN_CONTENT', '120px'),
        'footer_banner' => env('ADS_MIN_HEIGHT_FOOTER', '90px'),
    ],

    'push_idle_ms' => (int) env('ADS_PUSH_IDLE_MS', 800),

];
