let mix = require('laravel-mix');

var fs = require('fs'),
    dirname = __dirname;

var files = JSON.parse(fs.readFileSync(dirname + '/tools/build.json')).modules;

//如果是DEBUG生成到www文件夹，否则生成到dist文件夹
if (process.env.UFA_DEBUG === "true") {

    mix.setPublicPath('public/www/');
    files.forEach(function (ele, index) {
        console.log('resources/assets/js/' + ele.src + '.js');
        mix.js('resources/assets/js/' + ele.src + '.js', 'js/' + ele.dest);
    });

    files.forEach(function (ele, index) {
        mix.sass('resources/assets/sass/' + ele.src + '.scss', 'css/' + ele.dest);
    })
} else {

    mix.setPublicPath('public/dist/');
    files.forEach(function (ele, index) {
        mix.js('resources/assets/js/' + ele.src + '.js', 'js/' + ele.dest).version();
    });
    files.forEach(function (ele, index) {
        mix.sass('resources/assets/sass/' + ele.src + '.scss', 'css/' + ele.dest).version();
    })
}

if (process.argv.includes('all')) {

    mix.js('resources/assets/js/app.js', 'js')
        .sass('resources/assets/sass/app.scss', 'css').options({
        processCssUrls: false
    });


    mix.copy('resources/assets/lib/', 'public/www/lib');
    mix.copy('resources/assets/font', 'public/www/font');
    mix.copy('resources/assets/images', 'public/www/images');

}

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


