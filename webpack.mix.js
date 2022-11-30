const mix = require('laravel-mix');
const path = require('path');

const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({
    path: '../../.env',
    debug: true
}));

//require('laravel-mix-merge-manifest');
//mix.setPublicPath('../../../public_html').mergeManifest();

var public_path = 'Resources/dist';


mix.js('Resources/js/app.js', 'js');
mix.sass('Resources/scss/app.scss', 'css');

mix.setPublicPath(public_path);

mix.extract();

mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve(__dirname, 'node_modules')
        ]
    },

});

//mix.version();
mix.sourceMaps();

var $from = './Resources/dist';
var $to = '../../../public_html/themes/Two/dist';
console.log('from :' + $from);
console.log('to :' + $to);

//UnhandledPromiseRejectionWarning: Error: ENOENT: no such file or directory, open 'F:\var\www\base_xxx\laravel\Themes\AdminLTE\Resources\views\dist\public_html\themes\AdminLTE\dist\admin-lte.css'
//Error: ENOENT: no such file or directory, open 'F:\Resources\views\dist\css\admin-lte.css'

mix.copyDirectory($from, $to);
