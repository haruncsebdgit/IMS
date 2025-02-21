const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/vendor-frontend.js', 'public/js')
    .js('resources/js/frontend.js', 'public/js')
    .js('resources/js/dashboard-google-maps.js', 'public/js')
    .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .sass('resources/sass/auth.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/front-end/frontend.scss', 'public/css')
    .sass('resources/sass/bengali.scss', 'public/css');
