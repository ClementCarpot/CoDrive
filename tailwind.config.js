module.exports = {
  purge: [
    './templates/**/*.html.twig',
    './assets/**/*.js',
  ],
  darkMode: 'class', // or 'media' or 'false'
  theme: {
    extend: {
      backgroundImage: theme => ({
        'background-image': "url('/public/images/covoiturage.jpg')"
      })
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
