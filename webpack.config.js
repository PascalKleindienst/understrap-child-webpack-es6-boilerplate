const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

// Export Files
module.exports = (env) => {
    const isProduction = env === 'production';
    const CSSExtract = new ExtractTextPlugin('styles.css');

    return {
        entry: ['babel-polyfill', './src/app.js'],
        output: {
            path: path.join(__dirname, 'assets'),
            filename: 'bundle.js'
        },
        module: {
            rules: [{
                loader: 'babel-loader',
                test: /\.js$/,
                exclude: /node_modules/
            },
            {
                test: /\.s?css$/,
                use: CSSExtract.extract({
                    use: [
                        {
                            loader: 'css-loader',
                            options: { sourceMap: true }
                        },
                        {
                            loader: 'sass-loader',
                            options: { sourceMap: true }
                        },
                    ],
                }),
            }]
        },
        plugins: [
            CSSExtract,
        ],
        externals: {
            jquery: 'jQuery',
            popper: 'popper.js'
        },
        devtool: isProduction ? 'source-map' : 'inline-source-map'
    };
};