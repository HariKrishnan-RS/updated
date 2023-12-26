const mix = require("laravel-mix");

mix.js("resources/js/posts.js", "public/js").sass(
    "resources/sass/app.scss",
    "public/css"
);
