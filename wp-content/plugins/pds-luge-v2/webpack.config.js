const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  ...defaultConfig,
  entry: {
    editor:   './src/editor.js',
    frontend: './src/frontend.js',
    style:    './src/style.scss',
  },
  module: {
    rules: [
      ...(defaultConfig.module.rules || []),
      {
        test: /\.s?css$/i,
        use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
      },
    ],
  },
  plugins: [
    ...(defaultConfig.plugins || []),
    new MiniCssExtractPlugin({
      filename: ({ chunk }) => (chunk.name === 'style' ? 'style.css' : '[name].css'),
    }),
  ],
};
