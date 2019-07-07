const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/geoDist.js', 'public/js')
    .js('resources/js/edges.js', 'public/js')
    .copy(['resources/js/forms.js',
        'resources/js/scheduleMaker.js'], 'public/js')
    .sass('resources/sass/splash-screen.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/index.scss', 'public/css')
    .sass('resources/sass/forms.scss', 'public/css')
    .sass('resources/sass/media.scss', 'public/css');

var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
mix.webpackConfig({
    plugins: [
        new SWPrecacheWebpackPlugin({
            cacheId: 'pwa',
            filename: 'service-worker.js',
            staticFileGlobs: ['public/**/*.{css,eot,svg,ttf,woff,woff2,js,html,png,jpg}'],
            minify: true,
            stripPrefix: 'public/',
            handleFetch: true,
            dynamicUrlToDependencies: { //you should add the path to your blade files here so they can be cached
                //and have full support for offline first (example below)
                '/': ['resources/views/index.blade.php'],
                '/about-us': ['resources/views/about-us.blade.php'],
                '/Tansik/Geographic-Distribution-Information': ['resources/views/tansik/geo-dist-info.blade.php'],
                '/Tansik/Taqleel-al-eghterab': ['resources/views/tansik/reduce-alienation.blade.php'],
                '/Tansik/Tzalom': ['resources/views/tansik/tzaloom.blade.php'],
                // '/': ['resources/views/.blade.php'],
                // '/posts': ['resources/views/posts.blade.php']
            },
            staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
            navigateFallback: '/',
            runtimeCaching: [{
                    urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
                    handler: 'cacheFirst'
                },
                {
                    urlPattern: new RegExp('https://thanawyahelwa.org'),
                    handler: 'fastest'
                }
            ],
            // importScripts: ['./js/push_message.js']
        })
    ]
});