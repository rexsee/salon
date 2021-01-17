let mix = require('laravel-mix');

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

mix.combine([
    'resources/assets/js/jquery-3.2.1.min.js',
    'resources/assets/js/popper.min.js',
    // 'resources/assets/js/jquery-ui.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/datatables.min.js'
    ],'public/js/app.js')
    .combine([
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/jquery-confirm.min.js',
        'resources/assets/js/bootstrap.min.js',
        'resources/assets/js/plugins.min.js',
        'resources/assets/js/jquery.matchHeight.js',
        'resources/assets/js/main.js'
    ],'public/js/front.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .copy('resources/assets/fonts','public/fonts')
    .copy('resources/assets/js/modernizr.min.js','public/js')
    .copy('resources/assets/js/moment.min.js','public/js')
    .copy('resources/assets/js/tempusdominus-bootstrap-4.min.js','public/js')
    .copy('resources/assets/css/tempusdominus-bootstrap-4.min.css','public/css')
    .version();
