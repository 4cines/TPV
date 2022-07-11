//configuración más básica de webpack 

const path = require('path');

module.exports = {
  mode: 'development',
  entry: './assets/js/app.js',
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'dist'),
  },
};