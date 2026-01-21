import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: 'none',
                        color: 'inherit',
                        p: {
                            marginTop: '1.25em',
                            marginBottom: '1.25em',
                        },
                        'p:first-of-type': {
                            marginTop: '0',
                        },
                        'p:last-of-type': {
                            marginBottom: '0',
                        },
                        img: {
                            marginTop: '2em',
                            marginBottom: '2em',
                            borderRadius: '0.5rem',
                        },
                        h1: {
                            marginTop: '0',
                            marginBottom: '0.8em',
                        },
                        h2: {
                            marginTop: '2em',
                            marginBottom: '1em',
                        },
                        h3: {
                            marginTop: '1.6em',
                            marginBottom: '0.6em',
                        },
                        ul: {
                            marginTop: '1.25em',
                            marginBottom: '1.25em',
                        },
                        ol: {
                            marginTop: '1.25em',
                            marginBottom: '1.25em',
                        },
                    },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
};
