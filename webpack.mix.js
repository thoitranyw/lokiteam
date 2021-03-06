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

mix.react('resources/js/app.js', 'public/js')
   .react('resources/js/components/install_app.js', 'public/js/install_app.min.js')
   .react('resources/js/components/dashboard.js', 'public/js/dashboard.min.js').version()
   .react('resources/js/components/setting.js', 'public/js/setting.min.js').version()
   .react('resources/js/components/products.js', 'public/js/products.min.js').version()
   .copy('resources/js/uikit-icons.js', 'public/js/uikit-icons.min.js')
   .copy('resources/js/uikit.min.js', 'public/js/uikit.min.js')
   .copy('resources/js/uikit.min.js', 'public/js/uikit.min.js')
   .react('resources/js/frontend.js', 'public/js/frontend.min.js').version()
   .sass('resources/sass/scss/slider.scss', 'public/css/slider.min.css')
   .sass('resources/sass/scss/install_app.scss', 'public/css/install_app.min.css')
   .sass('resources/sass/app.scss', 'public/css/app.min.css')
   .sass('resources/sass/scss/frontend.scss', 'public/css/frontend.min.css');
