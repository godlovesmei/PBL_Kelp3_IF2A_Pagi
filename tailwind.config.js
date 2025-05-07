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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};

module.exports = {
    darkMode: 'class', // Bisa juga 'media' untuk mengikuti preferensi OS
    content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'], // Sesuaikan dengan struktur proyek Anda
    theme: {
      extend: {},
    },
    plugins: [],
  };
