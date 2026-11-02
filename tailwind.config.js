import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-c-buku',
        'bg-c-elektronik',
        'bg-c-pakaian',
        'bg-c-kuliah',
        'bg-c-lain',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                page: '#e9e9e9',
                brand: '#ff9d57',
                navy: '#07055e',
                'c-buku': '#e0bbf7',
                'c-elektronik': '#7b8cde',
                'c-pakaian': '#f0aeae',
                'c-kuliah': '#fbfe9f',
                'c-lain': '#d4d4d4',
            },
        },
    },

    plugins: [forms],
};