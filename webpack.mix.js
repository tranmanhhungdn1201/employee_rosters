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

// mix.webpackConfig({
//   module: {
//     rules: [{
//       test: /\.js?$/,
//       use: [{
//         loader: 'babel-loader',
//         options: mix.config.babel()
//       }]
//     }]
//   }
// });

// mix.autoload({
//    jquery: ['$', 'window.jQuery',"jQuery","window.$","jquery","window.jquery"],
//    moment: 'moment',
//    DataTable : 'datatables.net-dt',
// });

// mix.webpackConfig({
//    resolve: {
//       alias: {
//          jquery: "jquery/src/jquery"
//       }
//    }
// });

mix.sass('resources/sass/app.scss', 'public/css')
   .js('resources/js/app.js', 'public/js');