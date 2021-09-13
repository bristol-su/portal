const mix = require('laravel-mix');
const webpack = require('webpack');
const tailwindcss = require('tailwindcss');

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

mix.js('resources/js/app.js', 'public/js/app.js').vue()
    .js('resources/js/legacy.js', 'public/js/legacy.js').vue()
    .js('resources/js/header.js', 'public/js/header.js').vue()
    .js('resources/js/control.js', 'public/js/control.js').vue()
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .sass('resources/sass/legacy.scss', 'public/css/legacy.css')
    .copyDirectory('node_modules/@bristol-su/portal-ui-kit/src/assets', 'public', true)
    .postCss("resources/sass/ui-kit.css", "public/css/ui-kit.css", [require("tailwindcss")])
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
