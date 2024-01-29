const mix = require('laravel-mix');
require('mix-tailwindcss');

// paths
let inputAssetsPath = 'resources/assets/';
let outputAssetsPath = 'public/assets/';
mix.setPublicPath(outputAssetsPath);

// mix configuration
mix.options({
    processCssUrls: false
});

// # ------------------------------------- #
// # ----------  Compile assets  --------- #
// # ------------------------------------- #

mix.sass(inputAssetsPath + 'sass/index.scss', outputAssetsPath + 'index.css')
    .tailwind();
mix.js(inputAssetsPath + 'js/index.js', outputAssetsPath + 'index.js').vue({ version: 2 }).sourceMaps();

mix.version([
    outputAssetsPath + 'index.css',
    outputAssetsPath + 'index.js'
]);
