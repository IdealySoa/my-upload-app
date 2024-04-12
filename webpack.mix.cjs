const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/jquery/dist/jquery.min.js', 'public/js')
   .scripts([
       'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
       // Other script files
   ], 'public/js/app.js');