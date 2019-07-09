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

mix.options({
    purifyCss: {
        purifyOptions: {
            minify: true,
            whitelist: ['*.loaded*', '*.loading*']
        }
    },
    
});
mix.autoload({
    jquery: ['$', 'window.jQuery'],
    axios: ['axios', 'window.axios']
});

var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
var JavaScriptObfuscator = require('webpack-obfuscator'); //options at --> https://github.com/javascript-obfuscator/javascript-obfuscator

mix.webpackConfig({
    plugins: [
        // new JavaScriptObfuscator({
        //     controlFlowFlattening: mix.inProduction(),
        //     controlFlowFlatteningThreshold: 0.5,
        //     deadCodeInjection: mix.inProduction(),
        //     deadCodeInjectionThreshold: 0.2,
        //     debugProtection: mix.inProduction(),
        //     debugProtectionInterval: mix.inProduction(),
        //     disableConsoleOutput: mix.inProduction(),
        //     domainLock: mix.inProduction() ? ['thanawyahelwa.org', 'otscommunity.com'] : [],
        //     log: !mix.inProduction(),
        //     reservedStrings: [],
        //     seed: 10,
        //     selfDefending: mix.inProduction(),
        //     stringArray: mix.inProduction(),
        //     stringArrayEncoding: mix.inProduction(),
        //     stringArrayThreshold: 0.5,
        //     transformObjectKeys: mix.inProduction()

        // }),
        new SWPrecacheWebpackPlugin({
            cacheId: 'ThanawyaHelwa',
            filename: 'service-worker.js',
            //staticFileGlobs: ['public/**/*.{css,eot,svg,ttf,woff,woff2,js,html,png,jpg}'],
            minify: true,
            stripPrefix: 'public/',
            handleFetch: true,
            dynamicUrlToDependencies: {
                //you should add the path to your blade files here so they can be cached and have full support for offline first (example below)
                '/': ['resources/views/index.blade.php'],
                '/about-us': ['resources/views/about-us.blade.php'],
                //'/contact': ['resources/views/contact.blade.php'],
                //'/join-us': ['resources/views/join-us.blade.php'],
                //'/Tansik/Previous-Years-Edges': ['resources/views/tansik/previous-edges.blade.php'],
                //'/Tansik/Geographic-Distribution': ['resources/views/tansik/geo-dist.blade.php'],
                '/Tansik/Geographic-Distribution-Information': ['resources/views/tansik/geo-dist-info.blade.php'],
                '/Tansik/Taqleel-al-eghterab': ['resources/views/tansik/reduce-alienation.blade.php'],
                '/Tansik/Tzalom': ['resources/views/tansik/tzaloom.blade.php'],
                '/offline': ['resources/views/offline.blade.php'],
                // '/': ['resources/views/.blade.php'],
                // '/posts': ['resources/views/posts.blade.php']
            },
            staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
            navigateFallback: '/offline',
            runtimeCaching: [{
                    urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
                    handler: ' cacheFirst'
                },
                {
                    urlPattern: new RegExp('https://thanawyahelwa.org'),
                    handler: 'fastest'
                }
            ],
            importScripts: ['./js/service-worker.js']
            // importScripts: ['./js/push_message.js']
        })
    ]
});


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/geoDist.js', 'public/js')
    .js('resources/js/service-worker.js', 'public/js')
    .js('resources/js/edges.js', 'public/js')
    .js('resources/js/forms.js', 'public/js')
    //.js('resources/js/scheduleMaker.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/splash-screen.scss', 'public/css')
    .sass('resources/sass/forms.scss', 'public/css')
    .copyDirectory('resources/sass/fonts','public/css/fonts');

mix.version();