const defaultTheme = require('tailwindcss/defaultTheme');
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // <<< TAMBAHKAN BLOK 'colors' INI >>>
            colors: {
                primary: {
                    DEFAULT: '#065f46', // emerald-800
                    '50': '#ecfdf5',
                    '100': '#d1fae5',
                    '200': '#a7f3d0',
                    '300': '#6ee7b7',
                    '400': '#34d399',
                    '500': '#10b981', // emerald-600
                    '600': '#059669', // emerald-700
                    '700': '#047857',
                    '800': '#065f46', // emerald-800
                    '900': '#064e3b',
                    '950': '#022c22',
                },
                accent: {
                    DEFAULT: '#f59e0b', // amber-500
                    '50': '#fffbeb',
                    '100': '#fef3c7',
                    '200': '#fde68a',
                    '300': '#fcd34d', // amber-300
                    '400': '#fbbf24',
                    '500': '#f59e0b', // amber-500
                    '600': '#d97706',
                    '700': '#b45309',
                    '800': '#92400e',
                    '900': '#78350f',
                    '950': '#451a03',
                }
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
