/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../**/*.php', // Add this line to scan all PHP files
    './assets/**/*.{html,js}', // Include other file types if necessary
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

