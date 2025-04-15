const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Lexend', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#652EA3',
                secondary: '#420A82',
                darker: '#240E3E',
                lighter: '#451E71',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
