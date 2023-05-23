module.exports = {
  purge: [
    './templates/**/*.html.twig',
    './assets/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
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
