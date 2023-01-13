const mix = require('laravel-mix');

mix.options({
  cssNano: {
    discardComments: {
      removeAll: true,
    },
  },
});

mix.postCss(
  'src/resources/assets/raw/css/app.css',
  'src/resources/assets/compiled/css/bladewind-ui.min.css',
  [require('tailwindcss')]
);

// run npx mix --production to generate compiled css
