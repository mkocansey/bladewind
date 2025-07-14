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
                dark: colors.gray,
                green: colors.emerald,
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        animations
    ],
};