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

mix.js('resources/js/frontend.js', 'public/assets/js')
    .sass('resources/scss/frontend.scss', 'public/assets/css')
    .vue()
    .js('resources/js/backend.js', 'public/assets/js')
    .js('node_modules/@shopify/draggable/lib/draggable.bundle.js', 'public/assets/js/vendor')
    .sass('resources/scss/backend.scss', 'public/assets/css')
    .copyDirectory('resources/js/vendors/tinymce', 'public/assets/js/tinymce');
