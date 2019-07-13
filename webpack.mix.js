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

const CompressionPlugin = require('compression-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
mix.webpackConfig({
    plugins: [
        new UglifyJsPlugin({
            parallel: true,
            sourceMap: true,
            uglifyOptions: {
                output: {
                    comments: false
                },
                compress: true,
                ie8: true,
                safari10: true
            }
        }),
        new CompressionPlugin(),
        new SWPrecacheWebpackPlugin({
            cacheId: 'TH',
            globPatterns: ['public/**/*.{css,svg,ttf,js,png,jpg}'],
            minify: true,
            dynamicUrlToDependencies: {
                //you should add the path to your blade files here so they can be cached and have full support for offline first (example below)
                '/': 'resources/views/index.blade.php',
                '/about-us': 'resources/views/about-us.blade.php',
                '/Tansik/Geographic-Distribution-Information': 'resources/views/tansik/geo-dist-info.blade.php',
                '/Tansik/Taqleel-al-eghterab': 'resources/views/tansik/reduce-alienation.blade.php',
                '/Tansik/Tzalom': 'resources/views/tansik/tzaloom.blade.php',
                '/offline': 'resources/views/offline.blade.php'
            },
            staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
            navigateFallback: '/offline',
            navigateFallbackWhitelist: [/(.+\/)((Tansik\/.+)|(contact-us)|(join-us))/],
            runtimeCaching: [{
                    urlPattern: /((\/Tansik\/).+(Edges|Distribution$))|contact|join-us/,
                    handler: 'networkOnly'
                },
                {
                    //JS, CSS, or Images
                    urlPattern: /\.(?:css|js|png|jpg|jpeg|svg)$/,
                    handler: 'cacheFirst'
                },
                {
                    urlPattern: /.+/,
                    handler: 'fastest'
                }
            ],
            importScripts: ['./js/service-worker.js']
        })
    ]
});


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/service-worker.js', 'public/js')
    .js('resources/js/edges.js', 'public/js')
    .js('resources/js/forms.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/splash-screen.scss', 'public/css')
    .sass('resources/sass/forms.scss', 'public/css')
    .copyDirectory('resources/sass/fonts', 'public/css/fonts');

//Event
mix.sass('resources/sass/event.scss', 'public/css');
    
mix.version();
