const mix = require('laravel-mix');
const webpack = require('webpack');

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

mix.setPublicPath('./public');

mix.js('resources/js/app.js', 'public/js').vue()
    .js('resources/js/header.js', 'public/js').vue()
    .js('resources/js/control.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('./node_modules/@bristol-su/portal-ui-kit/src/install/ui-kit.css', 'public/css/ui-kit.css', [require('tailwindcss')])
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}

mix.webpackConfig({
    plugins: [
        new webpack.ProvidePlugin({
            'ui-kit': '@bristol-su/frontend-toolkit'
        })
    ]
});
