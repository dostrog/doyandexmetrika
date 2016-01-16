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
merge       = require('merge-stream'),
parseString = require('xml2js').parseString;
ver         = {};

parseString(fs.readFileSync('app/mod_doyandexmetrika.xml', 'ascii'), function(err, result) {

  ver = result.extension.version[0];

});


gulp.task('hello', function() {

  console.log( ver );
  console.log( config.name );

});
