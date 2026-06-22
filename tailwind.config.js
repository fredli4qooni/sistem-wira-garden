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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: 'var(--color-primary, #047857)', // Dynamic primary color
                secondary: '#059669', // Emerald 600 - Slightly lighter for hover
                accent: 'var(--color-accent, #ea580c)', // Dynamic accent color
                background: '#f8fafc', // Slate 50
                charcoal: '#1e293b', // Slate 800
            }
        },
    },

    plugins: [forms],
};
