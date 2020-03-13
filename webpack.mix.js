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
                    '/Tansik/Geographic-Distribution-Information': 'resources/views/tansik/geo-dist-info.blade.php',
                    '/Tansik/Taqleel-al-eghterab': 'resources/views/tansik/reduce-alienation.blade.php',
                    '/Tansik/Tzalom': 'resources/views/tansik/tzaloom.blade.php',
                    '/Tansik/Stages-Information': 'resources/views/tansik/stages-info.blade.php',
                },
                runtimeCaching: [
                    {
                        //JS, CSS, or Images
                        urlPattern: /\.(?:css|js|png|jpg|jpeg|svg)$/,
                        handler: 'StaleWhileRevalidate'
                    },
                    {
                        urlPattern: /((\/Tansik\/).+(Edges|Distribution$))|contact$|join-us$|TAS|\/team\//,
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
    .js("resources/js/edges.js", "public/js")
    .js("resources/js/forms.js", "public/js")
    .js("resources/js/members.js", "public/js")
    .js("resources/js/post.js", "public/js")
    .js("resources/js/notifications.js", "public/js")
    .scripts(
        [
            "resources/summernote/summernote.min.js",
            "resources/summernote/summernote-bs4.min.js"
        ],
        "public/js/texteditor.js"
    )
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/splash-screen.scss", "public/css")
    .sass("resources/sass/forms.scss", "public/css")
    .styles(
        "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
        "public/css/fontawesome.css"
    )
    .copy(
        "resources/summernote/font/summernote.woff",
        "public/css/font/summernote.woff"
    )
    .copy(
        "resources/summernote/font/summernote.ttf",
        "public/css/font/summernote.ttf"
    )
    .copy(
        "resources/summernote/font/summernote.eot",
        "public/css/font/summernote.eot"
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
