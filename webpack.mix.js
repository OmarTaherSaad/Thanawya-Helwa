const mix = require("laravel-mix");
mix.autoload({
    vue: ["Vue", "window.Vue"]
});
mix.options({
    imgLoaderOptions: {
        enabled: false
    }
});
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
const CompressionPlugin = require("compression-webpack-plugin");
if (mix.inProduction())
{
    mix.webpackConfig({
        plugins: [
            new CompressionPlugin(),
        ],
        output: {
            publicPath: ""
        }
    });
}

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/home.js", "public/js")
    .js("resources/js/edges.js", "public/js")
    .js("resources/js/forms.js", "public/js")
    .js("resources/js/members.js", "public/js")
    .js("resources/js/post.js", "public/js")
    .js("resources/js/email-sender.js", "public/js")
    .js("resources/js/notifications.js", "public/js")
    .js("resources/js/quizzes/quiz-maker.js", "public/js/quizzes")
    .js("resources/js/quizzes/general.js", "public/js/quizzes")
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
    .copyDirectory("resources/ckeditor", "public/texteditor")
    .copy("node_modules/@fortawesome/fontawesome-free/css/all.min.css", "public/css/fontawesome.css");
if (mix.inProduction())
{
    mix.version();
}
//Event
/*mix.sass('resources/sass/event.scss', 'public/css')
    .js('resources/js/ticketsScan.js', 'public/js')
    .js('resources/js/payment.js', 'public/js');
*/
