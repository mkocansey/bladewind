module.exports = {
  content: [
    "./public/**/*.js",
    "./resources/**/*.{html,php,js}", 
  ],
  safelist: [
    'bg-slate-200',
    'hover:bg-slate-300',
  ],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms')
  ],
};