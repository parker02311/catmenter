const defaultTheme = require("tailwindcss/defaultTheme");
const accent = "teal";
const linkColor = "blue";

module.exports = {
    darkMode: 'class',
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js",
        "./storage/framework/views/*.php",
        './app/**/*.php',
        "./resources/views/**/*.blade.php",
        "./themes/catppuccin/**/*.{blade.php,js,vue,ts,jsx,tsx}",
    ],

    theme: {
        // Colors
        extend: {
            colors: {
                //white: "#636B77",
                accent: '#CFE2FD',
                normal: '#E7F0FE',
                button: '#5270fd',
                darkbutton: '#2f3949',
                darkmodetext: "#cbd5e1",
                darkmode: '#1A202C',
                darkmodehover: '#2D3748',
                darkmode2: '#252D3B',
                logo: '#5270fd',

                'secondary': {
                    50: 'var(--secondary-50, #ffffff)',
                    100: 'var(--secondary-100, #fafcff)',
                    200: 'var(--secondary-200, #ebeef3)',
                    300: 'var(--secondary-300, #bbbfd2)',
                    400: 'var(--secondary-400, #808498)',
                    500: 'var(--secondary-500, #606372)',
                    600: 'var(--secondary-600, #4d4f60)',
                    700: 'var(--secondary-700, #353741)',
                    800: 'var(--secondary-800, #1c1c20)',
                    900: 'var(--secondary-900, #000000)',
                },
                'primary': {
                    50: 'var(--primary-50, #EDF0FF)',
                    100: 'var(--primary-100, #C6DBFF)',
                    200: 'var(--primary-200, #9BBEFB)',
                    300: 'var(--primary-300, #799CD8)',
                    400: 'var(--primary-400, #5270FD)',
                },
                'danger': {
                    50: 'var(--danger-50)',
                    100: 'var(--danger-100)',
                    200: 'var(--danger-200)',
                    300: 'var(--danger-300)',
                    400: 'var(--danger-400)',
                },
                'success': {
                    50: 'var(--success-50)',
                    100: 'var(--success-100)',
                    200: 'var(--success-200)',
                    300: 'var(--success-300)',
                    400: 'var(--success-400)',
                },
            },
            fontFamily: {
                sans: ["roboto", ...defaultTheme.fontFamily.sans],
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        "--tw-prose-body": `var(--ctp-text)`,
                        "--tw-prose-headings": `var(--ctp-${accent})`,
                        "--tw-prose-lead": `var(--ctp-text)`,
                        "--tw-prose-links": `var(--ctp-${linkColor})`,
                        "--tw-prose-bold": `var(--ctp-${accent})`,
                        "--tw-prose-counters": `var(--ctp-${accent})`,
                        "--tw-prose-bullets": `var(--ctp-${accent})`,
                        "--tw-prose-hr": `var(--ctp-${accent})`,
                        "--tw-prose-quotes": `var(--ctp-${accent})`,
                        "--tw-prose-quote-borders": `var(--ctp-${accent})`,
                        "--tw-prose-captions": `var(--ctp-${accent})`,
                        "--tw-prose-code": `var(--ctp-${accent})`,
                        "--tw-prose-pre-code": `var(--ctp-${accent})`,
                        "--tw-prose-pre-bg": `var(--ctp-base)`,
                        "--tw-prose-th-borders": `var(--ctp-${accent})`,
                        "--tw-prose-td-borders": `var(--ctp-${accent})`,

                        "--tw-prose-invert-body": `var(--ctp-${accent})`,
                        "--tw-prose-invert-headings": `var(--ctp-${accent})`,
                        "--tw-prose-invert-lead": `var(--ctp-${accent})`,
                        "--tw-prose-invert-links": `var(--ctp-${linkColor})`,
                        "--tw-prose-invert-bold": `var(--ctp-${accent})`,
                        "--tw-prose-invert-counters": `var(--ctp-${accent})`,
                        "--tw-prose-invert-bullets": `var(--ctp-${accent})`,
                        "--tw-prose-invert-hr": `var(--ctp-${accent})`,
                        "--tw-prose-invert-quotes": `var(--ctp-${accent})`,
                        "--tw-prose-invert-quote-borders": `var(--ctp-${accent})`,
                        "--tw-prose-invert-captions": `var(--ctp-${accent})`,
                        "--tw-prose-invert-code": `var(--ctp-${accent})`,
                        "--tw-prose-invert-pre-code": `var(--ctp-${accent})`,
                        "--tw-prose-invert-pre-bg": `var(--ctp-base)`,
                        "--tw-prose-invert-th-borders": `var(--ctp-${accent})`,
                        "--tw-prose-invert-td-borders": `var(--ctp-${accent})`,
                    },
                },
            }),
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [require('@tailwindcss/typography'), require('flowbite/plugin'), require('autoprefixer'), require("@catppuccin/tailwindcss")({
        prefix: "ctp",
        defaultFlavour: "mocha",
    })],
};
