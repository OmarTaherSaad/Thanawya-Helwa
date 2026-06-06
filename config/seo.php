<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Redirect non-APP_URL hosts to APP_URL (301)
    |--------------------------------------------------------------------------
    |
    | When true, requests whose Host header differs from the host in APP_URL
    | are redirected to the same path on APP_URL (fixes www vs apex duplicates).
    | Set false only for special local setups (e.g. multiple dev hostnames).
    |
    */
    'canonical_host_redirect' => filter_var(env('SEO_CANONICAL_HOST_REDIRECT', '1'), FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Default Open Graph / social preview image (absolute URL recommended)
    |--------------------------------------------------------------------------
    */
    'default_og_image' => env('SEO_DEFAULT_OG_IMAGE', ''),

    /*
    |--------------------------------------------------------------------------
    | Twitter @handle for twitter:site (optional)
    |--------------------------------------------------------------------------
    */
    'twitter_site' => env('SEO_TWITTER_SITE', ''),

    /*
    |--------------------------------------------------------------------------
    | Public site name (JSON-LD Organization / WebSite; may differ from APP_NAME)
    |--------------------------------------------------------------------------
    */
    'site_name' => env('SEO_SITE_NAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Absolute URL to logo for Organization schema (optional)
    |--------------------------------------------------------------------------
    */
    'organization_logo' => env('SEO_ORGANIZATION_LOGO', ''),

    /*
    |--------------------------------------------------------------------------
    | Open Graph locale (e.g. ar_EG)
    |--------------------------------------------------------------------------
    */
    'og_locale' => env('SEO_OG_LOCALE', 'ar_EG'),

];
