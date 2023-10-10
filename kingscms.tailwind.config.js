const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    "./resources/views/craftable-pro.blade.php",
    "./resources/js/craftable-pro/**/*.vue",
    "./resources/kingscms/resources/js/**/*.vue",
    "./vendor/brackets/craftable-pro/resources/js/**/*.vue"
  ],

  theme: {
    extend: {
      colors: {
        primary: colors.blue,
        secondary: colors.fuchsia,
        gray: colors.slate,
        warning: colors.amber,
        danger: colors.red,
        success: colors.lime,
        info: colors.sky,
      },
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
      },
      screens: {
        '3xl': '1800px',
      },
    },
  },

  plugins: [require("@tailwindcss/typography"), require("@tailwindcss/forms")],
};
