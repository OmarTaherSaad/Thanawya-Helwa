<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => false, // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'Thanawya Helwa - Dashboard'
            'description'  => 'ثانوية حلوة: فريق تطوعي يساعد طلبة الثانوية العامة المصرية في التنسيق، الجامعات، الكليات، والامتحانات.',
            'separator'    => ' | ',
            'keywords'     => array_merge([], (static function (): array {
                $path = storage_path('app/keywords.json');
                if (! is_readable($path)) {
                    return [];
                }
                $decoded = json_decode((string) file_get_contents($path), true);

                return is_array($decoded) ? $decoded : [];
            })()),
            'canonical'    => null,
            'robots'       => 'index,follow',
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => config('app.name', 'Thanawya Helwa'),
            'description' => 'ثانوية حلوة: فريق تطوعي يساعد طلبة الثانوية العامة المصرية في التنسيق والجامعات والامتحانات.',
            'url'         => null,
            'type'        => 'website',
            'site_name'   => config('app.name', 'Thanawya Helwa'),
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => filled(config('seo.twitter_site')) ? config('seo.twitter_site') : false,
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => config('app.name', 'Thanawya Helwa'),
            'description' => 'ثانوية حلوة: فريق تطوعي يساعد طلبة الثانوية العامة المصرية في التنسيق والجامعات والامتحانات.',
            'url'         => null,
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
