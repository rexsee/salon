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

mix.combine([
    'resources/assets/js/jquery-3.2.1.min.js',
    'resources/assets/js/popper.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/datatables.min.js'
    ],'public/js/app.js')
    .combine([
        'public/plugins/jquery/jquery.min.js',
        'public/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        'public/plugins/datatables/jquery.dataTables.js',
        'public/plugins/datatables-bs4/js/dataTables.bootstrap4.js',
        'public/plugins/fontawesome/js/fontawesome-all.js',
        'public/plugins/moment/moment.min.js',
        'public/plugins/select2/js/select2.full.min.js',
        'public/js/adminlte.min.js',
        'public/js/noty.js',
    ], 'public/js/admin.min.js')
    .combine([
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/jquery-confirm.min.js',
        'resources/assets/js/bootstrap.min.js',
        'resources/assets/js/plugins.min.js',
        'resources/assets/js/jquery.matchHeight.js',
        'resources/assets/js/main.js'
    ],'public/js/front.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/adminlte.scss', 'public/css/admin.css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .copy('resources/assets/fonts','public/fonts')
    .copy('resources/assets/js/modernizr.min.js','public/js')
    .copy('resources/assets/js/moment.min.js','public/js')
    .copy('resources/assets/js/tempusdominus-bootstrap-4.min.js','public/js')
    .copy('resources/assets/css/tempusdominus-bootstrap-4.min.css','public/css')
    .version();
