import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#1F555F',   // Main primary color
                },
                secondary: {
                    DEFAULT: '#DDE9F1',   // Main primary color
                },
                background: {
                    light: '#DDE9F1',  // Light background color
                    dark: '#1F555F',    // Dark background color
                },
                button: {
                    primary: {
                      DEFAULT: '#1F555F',       // Primary button color
                      hover: '#276873',         // Lighter hover color
                      active: '#173D45',        // Darker active color
                      disabled: '#A0B5BA'       // Muted disabled color
                    },
                },
            },
        },
    },
    plugins: [
        // require('@tailwindcss/forms'),
        require('flowbite/plugin')({
            datatables: true,
        }),
    ],

    
    
};

