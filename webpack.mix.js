const mix = require('laravel-mix');

mix.options({
  cssNano: {
    discardComments: {
      removeAll: true,
    },
  },
});

mix.postCss('resources/assets/css/app.css', 'public/css//bladewind-ui.min.css', [
      require('tailwindcss')
    ]);

// run npx mix --production to generate compiled css
// npx mix watch when in dev
