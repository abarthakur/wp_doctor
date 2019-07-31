'use strict';

const imagemin = require('gulp-imagemin');
var gulp = require('gulp'),
    pkg = require('./package.json'),
    toolkit = require('gulp-wp-toolkit');

toolkit.extendConfig({
    theme: {
        name: "Doctor Theme",
        homepage: pkg.homepage,
        description: pkg.description,
        author: pkg.author,
        version: pkg.version,
        license: pkg.license,
        textdomain: pkg.name
    },
    src:{
        scss:'css/sass/**/*.scss'
    },
    js: {
        'main' : [
             'js/dev/core.js'
         ],
    }
    ,
    css:{
        scss: {
            style:{
                src:'css/sass/main.scss',
                dest:'css/',
                outputStyle:'',
                notify:false
            }
        }
    }
});

toolkit.extendTasks(gulp, { /* Task Overrides */ });
 
gulp.task('build:icons', () =>
    gulp.src('./images/**/*')
        .pipe(imagemin())
        .pipe(gulp.dest('./images/dist/'))
);
