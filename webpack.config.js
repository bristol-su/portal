const path = require("path");
const development = process.env.NODE_ENV !== 'production';
const TerserJSPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const WebpackAssetsManifest = require('webpack-assets-manifest');

module.exports = {
    // Set the mode based on the NODE_ENV environment variable
    mode: development ? 'development' : 'production',

    // Optimization Information
    optimization: {
        // Only minimize for production
        minimize: !development,
        minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
    },

    // Entry points
    entry: {
        app: [
            './resources/js/app.js',
            './resources/sass/app.scss'
        ]
    },

    // Outputs
    output: {
        path: path.resolve(__dirname, './public'),
        filename: development ? 'js/[name].js' : 'js/[name].[chunkhash].js',
    },
    module: {
        rules: [
            // Loader for ecma script
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            },

            // Loader for sass.
            {
                test: /\.scss$/,
                // Convert the sass to css, then inject it
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            publicPath: (resourcePath, context) => {
                                // publicPath is the relative path of the resource to the context
                                // e.g. for ./css/admin/main.css the publicPath will be ../../
                                // while for ./css/main.css the publicPath will be ../
                                return path.relative(path.dirname(resourcePath), context) + '/';
                            },
                        }
                    },
                    'css-loader', 'sass-loader'
                ]
            },

            // Loader for css. Will take effect from right to left
            {
                test: /\.css$/,
                // Load the css, and inject it
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    'css-loader', 'sass-loader'
                ]
            }
        ]
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: development ? 'css/[name].css' : 'css/[name].[chunkhash].css',
            chunkFilename: development ? 'css/[id].css' : 'css/[id].[chunkhash].css',
        }),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: ['js/*', 'css/*'],
        }),
        new WebpackAssetsManifest({
            writeToDisk: true
        }),
    ]
}
