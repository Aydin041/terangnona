/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./resources/views/**/*.blade.php'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', '"Segoe UI"', 'Roboto', 'Arial', 'sans-serif'],
      },
      colors: {
        brand: {
          navy: '#0a1431',
          'navy-soft': '#12295a',
          amber: '#f5a31a',
          'amber-dark': '#d98a0a',
          blue: '#1f6fa8',
          'blue-light': '#2b8bc6',
        },
        surface: '#f4f6fb',
        ink: '#141b34',
        line: '#e1e6f0',
      },
    },
  },
  plugins: [],
};