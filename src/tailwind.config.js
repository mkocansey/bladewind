const colors = require('tailwindcss/colors')

module.exports = {
  mode: 'jit',
  purge: [
    './storage/framework/views/*.php',
    './publics/**/*.html',
    './resources/**/*.{blade.php,js}',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      gray: colors.slate,
      red: colors.red,
      orange: colors.orange,
      yellow: colors.amber,
      green: colors.emerald,
      blue: colors.blue,
      primary: {
        light: '#008CFF',
        DEFAULT: '#0066ff',
        dark: '#0432FF'
      }
    },
    extend: {
      colors: {
        gray: {
          150: '#f0f4f4' //#f7f9ff
        }
      }
    },
    fontFamily: {
      //'sans': 'Poppins',
    }
  },
  variants: {
    extend: {
      backgroundColor: ['checked', 'disabled'],
      borderColor: ['checked'],
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ]
}
