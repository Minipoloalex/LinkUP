/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue'
  ],
  theme: {
    extend: {},
    colors: {
      primary: '#000814',
      secondary: '#001D3D',
      accent: '#003566',
      white: '#FFFFFF',
      black: '#000000',
      transparent: 'transparent',
      ...defaultTheme.colors
    }
  },
  plugins: [],
  darkMode: 'class'
}
