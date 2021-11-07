const defaultTheme = require('tailwindcss/defaultTheme');
const path = require('path');
const colors = require('tailwindcss/colors');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        path.resolve(__dirname, './node_modules/litepie-datepicker/**/*.js'),
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            gridTemplateColumns: {
                // Simple 16 column grid
               '20': 'repeat(20, minmax(0, 1fr))',

                // Complex site-specific column configuration
               'footer': '200px minmax(900px, 1fr) 100px',
            },
            backgroundImage: {
                'main-background' : "url('/storage/main-background.jpg')",
            },
            colors: {
                // Change with you want it
                'litepie-primary': colors.lightBlue, // color system for light mode
                'litepie-secondary': colors.coolGray // color system for dark mode
              }
        },
        variants: {
            extend: {
              cursor: ['disabled'],
              textOpacity: ['disabled'],
              textColor: ['disabled']
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
