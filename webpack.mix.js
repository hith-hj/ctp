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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/default.js', 'public/js/default.js')
    .js('resources/js/front_scripts.js', 'public/js/front_scripts.js')
    .sass('resources/css/front_styles.scss', 'public/css/front_styles.css')
    .postCss('resources/css/default.css', 'public/css/default.css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .js('resources/js/admins.js', 'public/js/admins.js')
    .js('resources/js/roles.js', 'public/js/roles.js')
    .js('resources/js/users.js', 'public/js/users.js')
    .js('resources/js/coupons.js', 'public/js/coupons.js')
    .js('resources/js/products.js', 'public/js/products.js')
    .js('resources/js/attributes.js', 'public/js/attributes.js')
    .js('resources/js/categories.js', 'public/js/categories.js')
    .js('resources/js/sliders.js', 'public/js/sliders.js')
    .js('resources/js/banners.js', 'public/js/banners.js')
    .js('resources/js/currencies.js', 'public/js/currencies.js')
    .js('resources/js/notifications.js', 'public/js/notifications.js')
    .js('resources/js/review.js', 'public/js/review.js')
    .js('resources/js/filter-products.js', 'public/js/filter-products.js')
    .js('resources/js/order.js', 'public/js/order.js');

