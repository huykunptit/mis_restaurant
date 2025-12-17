module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
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
