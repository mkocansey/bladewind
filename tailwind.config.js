const colors = require("tailwindcss/colors");
import animations from "./public/js/animations";

module.exports = {
    darkMode: 'class',
    content: [
        "./public/**/*.js",
        "./resources/**/*.{html,php,js}",
    ],
    theme: {
        extend: {
            colors: {
                primary: colors.blue,
                secondary: colors.slate,
                green: colors.emerald,
                dark: {
                    100: '#f0f1f2',
                    200: '#d2d4d7',
                    300: '#a7aaad',
                    400: '#6c7075',
                    500: '#4a4e53',
                    600: '#33373c',
                    700: '#262a2f',
                    800: '#1C1F24',
                    900: '#101114',
                    950: '#0a0b0d'
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        animations
    ],
};