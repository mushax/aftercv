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
            colors: {
                'primary': '#0D253F',   // Navy Blue
                'secondary': '#01D277', // Emerald Green
                'danger': '#DC143C',    // Crimson Red
                'warning': '#FFC107',   // Amber
            },
            fontFamily: {
                // Reverted to the original, more stable font stack
                heading: ['Cairo', ...defaultTheme.fontFamily.sans],
                body: ['Tajawal', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
