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
if (process.env.section) {
    // public site
    mix.webpackConfig({
        resolve: {
            alias: {
            }
        }
    });
    mix.js('resources/js/app-public.js', 'public/assets/js')
        .sass('resources/sass/app-public.scss', 'public/assets/css')
        .copy('resources/assets/public', 'public')
} else {
    mix.webpackConfig({
        resolve: {
            alias: {
                'load-image': 'blueimp-load-image/js/load-image.js',
                'load-image-meta': 'blueimp-load-image/js/load-image-meta.js',
                'load-image-exif': 'blueimp-load-image/js/load-image-exif.js',
                'load-image-scale': 'blueimp-load-image/js/load-image-scale.js',
                'canvas-to-blob': 'blueimp-canvas-to-blob/js/canvas-to-blob.js',
                'load-image-orientation': 'blueimp-load-image/js/load-image-orientation.js',
                'jquery-ui/ui/widget': 'blueimp-file-upload/js/vendor/jquery.ui.widget.js'
            }
        }
    });
    mix.js('resources/js/app.js', 'public/admin/assets/js')
        .sass('resources/sass/app.scss', 'public/admin/assets/css')
        .copy('resources/assets/admin', 'public/admin');
}
