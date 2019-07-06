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
    .copy(['resources/js/pace.min.js',
    'resources/js/popper.min.js',
    'resources/js/forms.js',
    'resources/js/offline.min.js',
    'resources/js/scheduleMaker.js',
    'resources/js/jquery-ui.min.js',
    'resources/js/sorttable.js',
    'resources/js/tables.js'], 'public/js')
    .sass('resources/sass/splash-screen.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/css','public/css');