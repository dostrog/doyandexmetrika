var gulp = require('gulp');

// ZIP compress files
zip = require('gulp-zip'),

// Utility functions for gulp plugins
gutil = require('gulp-util')

// File systems
fs          = require('fs'),
path        = require('path'),
merge       = require('merge-stream'),
parseString = require('xml2js').parseString;
//var parser  = new xml2js.Parser();

var ver = '1';

parseString(fs.readFileSync('app/mod_doyandexmetrika.xml', 'ascii'), function(err, result) {

  ver = result.extension.version[0];

});


gulp.task('hello', function() {

  console.log( ver );

});
