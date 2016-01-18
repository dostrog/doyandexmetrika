var gulp = require('gulp');

// ZIP compress files
zip = require('gulp-zip'),

// Utility functions for gulp plugins
gutil = require('gulp-util')

// Gulp Configuration
config = require('./gulp-config.json')

// File systems
fs          = require('fs'),
parseString = require('xml2js').parseString;
imagemin    = require('gulp-imagemin'),
pngquant    = require('imagemin-pngquant'), // $ npm i -D imagemin-pngquant
git         = require('gulp-git'),
cache       = require('gulp-cache'),
ver         = {};

parseString(fs.readFileSync('app/mod_doyandexmetrika.xml', 'ascii'), function(err, result) {

  ver = result.extension.version[0];

});

gulp.task('imagemin', function() {
  gulp.src( 'app/media/images/**/*.+(png|jpg|jpeg|gif|svg)' )
    // Caching images that ran through imagemin
    .pipe(cache(imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{removeViewBox: false}],
      use: [pngquant()]
    })))
  .pipe(gulp.dest('app/media/images/'));
});

gulp.task('updateSubmodules', function(){
  git.updateSubmodule({ args: '--init --force' });
});

gulp.task('default', ['updateSubmodules','imagemin'], function() {
// Start up log
  gutil.log(gutil.colors.white.bgGreen('Preparing release for version ' + ver));
  gulp.src( config.packageFiles, { base: 'app' } )
    .pipe(zip('mod_' + config.name + '-v' + ver + '.zip'))
    .pipe(gulp.dest(config.releaseDir));
  gutil.log(gutil.colors.white.bgGreen('Component packages are ready at ' + config.releaseDir));
});
