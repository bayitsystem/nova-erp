let mix = require('laravel-mix')

mix
  .setPublicPath('dist')
  .js('Assets/js/erp.js', 'js')
  .sass('Assets/sass/erp.scss', 'css')
