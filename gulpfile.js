var gulp = require('gulp');

// ZIP compress files
zip = require('gulp-zip'),

// Utility functions for gulp plugins
gutil = require('gulp-util')

// Gulp Configuration
config = require('./gulp-config.json')

// File systems
fs          = require('fs'),
path        = require('path'),
gulpPath    = require('gulp-path'),
merge       = require('merge-stream'),
deb         = require('gulp-debug'),
parseString = require('xml2js').parseString;
ver         = {};

var assets = gulpPath.Base({
        src: './app',
        dest: config.releaseDir
    });

// Setting paths
var paths = {
        // img.dest = './resources/images/'
        // img.src = './assets/images/**/*'
//        img: new assets.Path('images'),
        // js.dest = './resources/js/'
        // js.src = './assets/js/**/*.js'
//        js: new assets.Path('js', 'js'),
        // fonts.dest = './public/fonts/'
        // fonts.src = './public/fonts/**/*'
//        fonts: new public.Path('fonts'),
        // controllers.dest = './controllers/'
        // controllers.src = './controllers/**/*.js'
        app: new assets.Path( config.packageFiles )
    };

//console.log('assets:' + paths.app.files() );

parseString(fs.readFileSync('app/mod_doyandexmetrika.xml', 'ascii'), function(err, result) {

  ver = result.extension.version[0];

});


gulp.task('hello', function() {

// Start up log
  gutil.log(gutil.colors.white.bgGreen('Preparing release for version ' + ver));

  gulp.src( config.packageFiles, { base: 'app' } )
    .pipe(zip('mod_' + config.name + '-v' + ver + '_testgulp' + '.zip'))
    .pipe(gulp.dest(config.releaseDir));

  gutil.log(gutil.colors.white.bgGreen('Component packages are ready at ' + config.releaseDir));

});
