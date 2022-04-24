let mix = require('laravel-mix');

mix
    .postCss('src/resources/assets/raw/css/app.css', 'src/resources/assets/compiled/css/bladewind-ui.min.css', [
        require('tailwindcss'),
    ]);

    // run npx mix to generate compiled css