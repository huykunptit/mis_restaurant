module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#ec7f13",
        "primary-light": "#fdf1e3", 
        "background-light": "#f8f7f6",
        "background-dark": "#221910",
        "card-dark": "#2d231a",
      },
      fontFamily: {
        "display": ["Plus Jakarta Sans", "sans-serif"]
      },
      borderRadius: {
        "DEFAULT": "0.25rem", 
        "lg": "0.5rem", 
        "xl": "0.75rem", 
        "2xl": "1rem", 
        "full": "9999px"
      },
      borderWidth: {
        DEFAULT: '1px',
        '0': '0',
        '2': '2px',
        '3': '3px',
        '4': '4px',
        '6': '6px',
        '8': '8px',
      }
    },
  },
  variants: {
    extend: {
      borderRadius: ['hover', 'focus'],
      display: ['hover', 'group-hover'],
      width: ['hover', 'group-hover'],
      borderWidth: ['hover', 'group-hover'],
      fontWeight: ['hover', 'group-hover'],
      overflow: ['hover', 'group-hover'],
      borderWidth: ['hover', 'group-hover', 'focus'],
    },
  },
  plugins: [],
}
