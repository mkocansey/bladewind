module.exports = {
  content: ['./resources/**/*.{html,php,js}'],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms')
  ],
};