const mix = require('laravel-mix'); // eslint-disable-line
const path = require('path'); // eslint-disable-line

mix.webpackConfig({
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
        },
    },
});

if (process.env.NODE_ENV === 'development') { // eslint-disable-line
    mix.sourceMaps();
}

mix.options({
    processCssUrls: false
});

mix.js('resources/js/admin_app.js', 'public/js').vue();
mix.js('resources/js/user_app.js', 'public/js').vue();
mix.js('resources/js/auth_app.js', 'public/js').vue();

mix.sass('resources/sass/admin_app.scss', 'public/css')
    .sass('resources/sass/auth_app.scss', 'public/css')
    .sass('resources/sass/error_app.scss', 'public/css')

    .copy('resources/js/vendor', 'public/js/vendor')
    .copy('resources/sass/vendor', 'public/css/vendor')
    .copy('node_modules/element-ui/lib/theme-chalk/index.css', 'public/css/vendor/element-ui.min.css')
    .copy('node_modules/element-ui/lib/theme-chalk/fonts', 'public/css/vendor/fonts')
    .version();
