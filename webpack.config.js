const Encore = require('@symfony/webpack-encore');
const ExtractCss = require("extract-text-webpack-plugin");

Encore
    .enableVueLoader()
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .enableSassLoader()
    .addStyleEntry('app', './web/assets/css/main.sass')
    .addEntry('main', './web/assets/js/main.js')
    .cleanupOutputBeforeBuild()
    .addPlugin(new ExtractCss("app.css"))
    .addLoader({
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
            loader: 'babel-loader',
            options: {
                presets: ['env']
            }
        }
    })
;

module.exports = Encore.getWebpackConfig();
