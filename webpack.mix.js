const mix = require('laravel-mix');
let WebpackShellPluginNext = require('webpack-shell-plugin-next');

// paths
let inputAssetsPath = 'resources/assets/';
let outputAssetsPath = 'public/assets/';
let modularFormsPath = 'vendor/andreamarelli/modular-forms/dist/';
let imetCorePath = 'vendor/andreamarelli/imet-core/dist/';
let envPath = mix.inProduction() ? 'prod/' : 'debug/';
mix.setPublicPath(outputAssetsPath);

// mix configuration
mix.options({
    processCssUrls: false
});

// # ------------------------------------------ #
// # ---------  Laravel localization  --------- #
// # ------------------------------------------ #
mix.webpackConfig({
    plugins: [
        new WebpackShellPluginNext({
            onBuildStart: {
                scripts: ['php artisan lang:js --quiet public/assets/lang.js']
            }
        })
    ]
});

mix.version([
    outputAssetsPath + 'lang.js',
]);


// # ------------------------------------- #
// # ----------  Import Packages  -------- #
// # ------------------------------------- #

mix.copyDirectory(modularFormsPath + 'fonts', outputAssetsPath + 'fonts/');
mix.copyDirectory(modularFormsPath + 'flags', outputAssetsPath + 'flags/');
mix.copyDirectory(modularFormsPath + 'images', outputAssetsPath + 'images/');
mix.copy(modularFormsPath + envPath + '*.js', outputAssetsPath);
mix.copy(modularFormsPath + envPath + '*.css', outputAssetsPath);
mix.copy(imetCorePath + envPath + '*.js', outputAssetsPath);
mix.copy(imetCorePath + envPath + '*.css', outputAssetsPath);

mix.version([
    // modular-forms
    outputAssetsPath + 'modular_forms_index.js',
    outputAssetsPath + 'modular_forms_index.css',
    outputAssetsPath + 'modular_forms_vendor.js',
    outputAssetsPath + 'modular_forms_vendor.css',
    outputAssetsPath + 'modular_forms_vendor_leaflet.js',
    outputAssetsPath + 'modular_forms_vendor_leaflet.css',
    // imet-core
    outputAssetsPath + 'imet_core_index.js',
    outputAssetsPath + 'imet_core_index.css',
    outputAssetsPath + 'imet_core_vendor.js',
    outputAssetsPath + 'imet_core_vendor.css',
]);


// # ------------------------------------- #
// # ----------  Compile vendors  -------- #
// # ------------------------------------- #

mix.js(inputAssetsPath + 'js/vendor.js', outputAssetsPath + 'vendor.js').sourceMaps();
mix.sass(inputAssetsPath + 'sass/vendor.scss',   outputAssetsPath + 'vendor.css');

mix.version([
    outputAssetsPath + 'vendor.js',
    outputAssetsPath + 'vendor.css',
]);

// # ------------------------------------- #
// # -------  Compile local assets  ------ #
// # ------------------------------------- #

mix.sass(inputAssetsPath + 'sass/index.scss', outputAssetsPath + 'index.css');
mix.js(inputAssetsPath + 'js/index.js', outputAssetsPath + 'index.js').vue({ version: 2 }).sourceMaps();

mix.version([
    outputAssetsPath + 'index.css',
    outputAssetsPath + 'index.js'
]);
