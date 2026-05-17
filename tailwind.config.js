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
                sans: ['Space Mono', 'IBM Plex Mono', ...defaultTheme.fontFamily.mono],
                mono: ['Space Mono', 'IBM Plex Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                neuro: {
                    bg: '#f0f0f0',
                    dark: '#1a1a1a',
                    purple: '#9b5de5',
                    pink: '#f15bb5',
                    yellow: '#fee440',
                    cyan: '#00bbf9',
                    green: '#00f5d4',
                    orange: '#ff6b35',
                    red: '#e63946',
                },
                neo: {
                    bg: '#f0f0f0',
                    black: '#000000',
                    white: '#ffffff',
                    yellow: '#ffff00',
                    pink: '#ff00ff',
                    cyan: '#00ffff',
                    green: '#00ff00',
                    purple: '#9b5de5',
                    orange: '#ff6b35',
                    red: '#e63946',
                    blue: '#00bbf9',
                }
            },
            boxShadow: {
                'neo': '4px 4px 0px 0px #000000',
                'neo-sm': '2px 2px 0px 0px #000000',
                'neo-lg': '6px 6px 0px 0px #000000',
                'neo-xl': '8px 8px 0px 0px #000000',
                'neo-hover': '2px 2px 0px 0px #000000',
            },
            borderWidth: {
                '3': '3px',
            }
        },
    },

    plugins: [forms],
};