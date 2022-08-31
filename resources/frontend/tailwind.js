module.exports = {
  purge: [],
  theme: {
    extend: {
      colors: {
        accent: {
          lighter: '#F5E4AB',
          default: '#DEAE53',
          dark: '#BA8E52'
        },
        blue: {
          default: '#4545FF'
        },
        green: {
          default: '#00A05C'
        },
        gray: {
          '100': '#f5f5f5',
          '200': '#eeeeee',
          '300': '#e0e0e0',
          '400': '#bdbdbd',
          '500': '#9e9e9e',
          '600': '#757575',
          '700': '#616161',
          '800': '#424242',
          '900': '#242424',
          'alt1': '#808080',
          'alt2': '#525252',
          'alt3': '#A2A2A2',
          'places' : '#e0e0e0'
        },
        bronze: {
          default:'#B28C66'
        },
        silver: {
          default:'#717273'
        },
        gold: {
          default:'#BA8E52'
        }
      }
    },
  },
  variants: {},
  plugins: [],
  future: {
    removeDeprecatedGapUtilities: true,
  },
}
