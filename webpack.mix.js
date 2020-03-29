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
const workboxPlugin = require('workbox-webpack-plugin');
if (mix.inProduction())
{
    mix.webpackConfig({
        plugins: [
            new CompressionPlugin(),
            new workboxPlugin.GenerateSW({
                importWorkboxFrom: 'local',
                cacheId: 'TH',
                cleanupOutdatedCaches: true,
                skipWaiting: true,
                clientsClaim: true,
                ignoreURLParametersMatching: [/./],
                exclude: ['node_modules/**/*', '**map*', '**/*manifest*', '**service-worker*/'],
                templatedURLs: {
                    '/offline': 'resources/views/offline.blade.php',
                    '/': 'resources/views/index.blade.php',
                    '/about-us': 'resources/views/about-us.blade.php',
                    '/tansik/geographic-distribution-information': 'resources/views/tansik/geo-dist-info.blade.php',
                    '/tansik/taqleel-al-eghterab': 'resources/views/tansik/reduce-alienation.blade.php',
                    '/tansik/tzalom': 'resources/views/tansik/tzaloom.blade.php',
                    '/tansik/stages-information': 'resources/views/tansik/stages-info.blade.php',
                },
                runtimeCaching: [
                    {
                        //CSS or Images
                        urlPattern: /\.(?:css|png|jpg|jpeg|svg)$/,
                        handler: 'StaleWhileRevalidate'
                    },
                    {
                        //JS
                        urlPattern: /\.(?:js)$/,
                        handler: 'NetworkFirst'
                    },
                    {
                        urlPattern: /((\/tansik\/).+(edges|distribution$))|contact$|join-us$|TAS|\/team\//,
                        handler: 'NetworkOnly'
                    }
                ],
                importScripts: ['./js/service-worker.js']
            })
        ],
        output: {
            publicPath: ''
        }
    });
}


mix.js("resources/js/app.js", "public/js")
    .js("resources/js/service-worker.js", "public/js")
    .js("resources/js/home.js", "public/js")
    .js("resources/js/edges.js", "public/js")
    .js("resources/js/forms.js", "public/js")
    .js("resources/js/members.js", "public/js")
    .js("resources/js/post.js", "public/js")
    .js("resources/js/notifications.js", "public/js")
    .js("resources/js/quizzes/quiz-maker.js", "public/js/quizzes")
    .js("resources/js/quizzes/general.js", "public/js/quizzes")
    .scripts(
        [
            "resources/summernote/summernote.min.js",
            "resources/summernote/summernote-bs4.min.js"
        ],
        "public/js/texteditor.js"
    )
    .scripts(
        [
            "resources/js/effects/jquery-migrate-3.0.1.min.js",
            "resources/js/effects/jquery.animateNumber.min.js",
            "resources/js/effects/jquery.easing.1.3.js",
            "resources/js/effects/jquery.waypoints.min.js"
        ],
        "public/js/effects.js"
    )
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/home.scss", "public/css")
    .sass("resources/sass/splash-screen.scss", "public/css")
    .sass("resources/sass/forms.scss", "public/css")
    .styles(
        "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
        "public/css/fontawesome.css"
    )
    .styles("resources/css/animate.css", "public/css/theme.css")
    .copy(
        "resources/summernote/font/summernote.woff",
        "public/css/fonts/summernote.woff"
    )
    .copy(
        "resources/summernote/font/summernote.ttf",
        "public/css/fonts/summernote.ttf"
    )
    .copy(
        "resources/summernote/font/summernote.eot",
        "public/css/fonts/summernote.eot"
    )
    .styles(
        [
            "resources/summernote/summernote.css",
            "resources/summernote/summernote-bs4.css"
        ],
        "public/css/texteditor.css"
    )
    .copyDirectory(
        "node_modules/@fortawesome/fontawesome-free/webfonts",
        "public/webfonts"
    )
    .copyDirectory("resources/sass/fonts", "public/css/fonts");

//Event
/*mix.sass('resources/sass/event.scss', 'public/css')
    .js('resources/js/ticketsScan.js', 'public/js')
    .js('resources/js/payment.js', 'public/js');
*/
