var gulp							= require('gulp');
var rename     = require('gulp-rename');
var concat     = require('gulp-concat');
var noCom      = require('gulp-strip-comments');
var uglify     = require('gulp-uglify');
var stylus					= require('gulp-stylus');
var prefix					= require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var noCssCom   = require('gulp-strip-css-comments');
var cleanCSS   = require('gulp-clean-css');


// Converts Stylus files to CSS
gulp.task('stylus', function() {
    return gulp.src('stylus/style.styl')
               .pipe(sourcemaps.init())
               .pipe(stylus())
               .pipe(prefix(['last 15 versions', '> 1%'], {cascade: true}))
               .pipe(sourcemaps.write())
               .pipe(gulp.dest('css/'));
});

// Minifies CSS
gulp.task('css', function() {
    return gulp.src('css/*.css')
               .pipe(noCssCom())
               .pipe(cleanCSS())
               .pipe(gulp.dest('css/'));
});

// Watches source files and automatically updates build
gulp.task('watch', function() {
    gulp.watch('stylus/source/*.styl', ['stylus']);
});

// Development build
gulp.task('default', ['stylus', 'watch']);

// Production build
gulp.task('build', ['css']);
