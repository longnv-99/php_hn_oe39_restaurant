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
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/home.js', 'public/js')
    .js('resources/js/manage_user.js', 'public/js')
    .js('resources/js/manage_review_comment.js', 'public/js')
    .js('resources/js/profile.js', 'public/js')
    .js('resources/js/like_and_favorite.js', 'public/js')
    .js('resources/js/realtime-follow-notify.js', 'public/js')
    .js('resources/js/notify_when_favorite_book_deleted.js', 'public/js')
    .js('node_modules/chart.js/dist/chart.min.js', 'public/js')
    .js('resources/js/book_statistic.js', 'public/js')
    .postCss('resources/css/home.css', 'public/css')
    .postCss('resources/css/manage_review_comment.css', 'public/css');
