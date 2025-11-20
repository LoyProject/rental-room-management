import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Add Khmer font as the default sans so Tailwind's `font-sans` uses it
                sans: ['"Hanuman"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
