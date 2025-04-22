const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/**/*.blade.php',
    './resources/**/*.vue',
  ],
  safelist: [
    {
      pattern: /bg-(red|green|blue|yellow|indigo|gray)-(100|200|300|400)/,
    },
    {
      pattern: /text-(red|green|blue|gray)-700/,
    },
    {
      pattern: /border-(red|green|gray)-500/,
    },
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};
