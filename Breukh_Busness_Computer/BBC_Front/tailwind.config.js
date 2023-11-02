/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,ts}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      margin: {
        '550': '45vh',
      },
      backgroundColor: {
        'custom-yellow': '#E3A008',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

