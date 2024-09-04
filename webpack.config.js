const autoprefixer = require('autoprefixer');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');

module.exports = {
	mode: 'production' ,
	entry: {
			script: {
				import: './src/js/index.js',
				dependOn: 'shared',
			  },
			shared: ['plyr', 'flickity', 'gsap'],
			style: './src/sass/style.scss',
	},
	output: {
		path: path.resolve(__dirname, 'assets/'),
		filename: '[name].bundle.js',
	},
	optimization: {
		runtimeChunk: 'single',
	},
	devtool: "source-map",
	plugins: [
		new MiniCssExtractPlugin({
		  filename: 'style-v1.3.css',
		  chunkFilename: '[id].css',
		}),
	  ],
	module: {
		rules: [
			{
				test: /\.scss$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true
						  }
					},
					{
						loader: 'resolve-url-loader',
					},
					{
						loader: 'postcss-loader'
					},
					{
						loader: 'sass-loader',
						options: {
							implementation: require("sass"),
							sourceMap: true,
						  }
					}
				]
			},
			{
				test: /\.(eot|ttf|woff|woff2)$/,
				use: {
					loader: 'file-loader',
					options: {
						name: '[name].[ext]',
						outputPath: 'webfonts'
					},
				},
			},
			{
				test: /\.(svg)$/,
				use: {
					loader: 'file-loader',
					options: {
						name: '[name].[ext]',
						outputPath: 'images'
					},
				},
			}
		]
	},
};