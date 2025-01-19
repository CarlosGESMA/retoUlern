/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: 'media', 
  theme: {
    extend: {
      colors: {
        customRed: '#e52026',
        primaryRed: '#E42127',
        secondaryRed: '#EF5350',
        primaryGray: '#757575',
        secondaryGray: '#3A505E',
        bgRed: '#E42127',
        bgInpuGray: '#ECEFF1',
        bgGray: '#CFD8DC',
        bgSelectedScroll: '#FFB1B1',
        bgScroll: '#FFD9D9',
    },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}