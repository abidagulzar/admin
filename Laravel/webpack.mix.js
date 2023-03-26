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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.scripts([
    'public/site/assets/js/jquery-1.11.1.min.js',
    'public/site/assets/js/bootstrap.min.js',
    'public/site/assets/js/bootstrap-hover-dropdown.min.js',
    'public/site/assets/js/owl.carousel.min.js',
    'public/site/assets/js/echo.min.js',
    'public/site/assets/js/jquery.easing-1.3.min.js',
    'public/site/assets/js/bootstrap-slider.min.js',
    'public/site/assets/js/jquery.rateit.min.js',
    'public/site/assets/js/lightbox.min.js',
    'public/site/assets/js/bootstrap-select.min.js',
    'public/site/assets/js/wow.min.js',
    'public/site/assets/js/scripts.js',
    'public/site/assets/js/countdown.js',
    'public/site/assets/js/jquery.form.min.js',
    'public/site/assets/js/shuffle/prism.js',
    'public/site/assets/js/shuffle/shim.min.js',
    'public/site/assets/js/shuffle/shuffle.js',
    'public/site/assets/js/shuffle/homepage.js',
], 'public/js/site.js').version();

mix.styles([
    'public/site/assets/css/shuffle/shuffle-bootstrap-style.css',
    'public/site/assets/css/shuffle/shuffle-style.css',
    'public/site/assets/css/main.css',
    'public/site/assets/css/blue.css',
    'public/site/assets/css/owl.carousel.css',
    'public/site/assets/css/owl.transitions.css',
    'public/site/assets/css/rateit.css',
    'public/site/assets/css/bootstrap-select.min.css'
], 'public/css/site.css').version();
