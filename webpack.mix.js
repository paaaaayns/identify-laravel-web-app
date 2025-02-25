const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .copyDirectory("resources/assets/images", "public/images");

if (mix.inProduction()) {
    mix.version();
}
