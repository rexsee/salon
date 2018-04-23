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
    // 'resources/assets/js/jquery-ui.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/datatables.min.js'
    // 'resources/assets/js/dataTables.bootstrap4.min.js',
    // 'resources/assets/js/responsive.bootstrap4.min.js'
    ],'public/js/app.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .copy('resources/assets/fonts','public/fonts')
    .version();
