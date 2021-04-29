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
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'public/theme/plugins/datatables/jquery.dataTables.min.js',
        'public/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        'public/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js',
        'public/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        'public/js/dataTables.buttons.min.js',
        'public/js/buttons.flash.min.js',
        'public/js/jszip.min.js',
        'public/js/pdfmake.min.js',
        'public/js/vfs_fonts.js',
        'public/js/buttons.html5.min.js',
        'public/js/buttons.print.min.js',
    ], 'public/js/datatable.js');
