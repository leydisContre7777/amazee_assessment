'use strict';

const gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    copy = require('gulp-copy'),
    clean = require('gulp-clean'),
    sourcemaps = require('gulp-sourcemaps'),
    fs = require('fs-extra'),
    minify = require('gulp-clean-css');
    Promise = require('bluebird');

/**
 * `
 *  gulp sass
 * `
 * Compile and bundle sass files
 * All sass files from src folder will be compiled
 * and bundled
 */
gulp.task('sass', () => {
    const sassSource = gulp.src('src/**/*.sass')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError));


    sassSource.pipe(concat('style.min.css'))
        .pipe(minify({compatibility: 'ie9'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('css'));

    sassSource.pipe(concat('style.css'))
        .pipe(gulp.dest('css'));
});

/**
 * `
 *  gulp sass-watch
 * `
 * Watch for sass files
 */
gulp.task('sass-watch', () => {
    gulp.watch('src/**/*.sass', ['sass']);
});

/**
 * `
 *  gulp vendors
 * `
 * Copy vendor libraries from node_modules
 */
gulp.task('vendors', () => {
    gulp.start('vendors:font-awesome');
    gulp.start('vendors:bootstrap');
    gulp.start('vendors:propeller');
    gulp.start('vendors:swiper');
    gulp.start('vendors:wowjs');
});

/**
 * Font awesome vendor
 */
gulp.task('vendors:font-awesome', () => {

    if(fs.existsSync('vendor/font-awesome')) {
        fs.removeSync('vendor/font-awesome');
    }

    ['css', 'fonts'].forEach(folder =>
        fs.copySync(
            `node_modules/font-awesome/${folder}`,
            `vendor/font-awesome/${folder}`
        )
    );
});

/**
 * Bootstrap vendor
 */
gulp.task('vendors:bootstrap', () => {
    if(fs.existsSync('vendor/bootstrap')) {
        fs.removeSync('vendor/bootstrap');
    }

    ['css', 'js'].forEach(folder =>
        fs.copySync(
            `node_modules/bootstrap/dist/${folder}`,
            `vendor/bootstrap/${folder}`
        )
    );
});

/**
 * Propeller vendor
 */
gulp.task('vendors:propeller', () => {
    if(fs.existsSync('vendor/propeller')) {
        fs.removeSync('vendor/propeller');
    }

    ['propeller.css','propeller.min.css','propeller.min.css.map'].forEach(file =>
        fs.copySync (
            `node_modules/propellerkit/dist/css/${file}`,
            `vendor/propeller/css/${file}`
        )
    );

    ['propeller.js','propeller.min.js','propeller.js.map'].forEach(file =>
        fs.copySync (
            `node_modules/propellerkit/dist/js/${file}`,
            `vendor/propeller/js/${file}`
        )
    );

    ['fonts'].forEach(folder =>
        fs.copySync(
            `node_modules/propellerkit/dist/${folder}`,
            `vendor/propeller/${folder}`
        )
    );
});

/**
 * Swiper vendor
 */
gulp.task('vendors:swiper', () => {
    if(fs.existsSync('vendor/swiper')) {
        fs.removeSync('vendor/swiper');
    }

    ['css', 'js'].forEach(folder =>
        fs.copySync(
            `node_modules/swiper/dist/${folder}`,
            `vendor/swiper/${folder}`
        )
    );
});

/**
 * WOWjs and Animate.css vendor
 */
gulp.task('vendors:wowjs', () => {
    if(fs.existsSync('vendor/animate')) {
        fs.removeSync('vendor/animate');
    }
    if(fs.existsSync('vendor/wowjs')) {
        fs.removeSync('vendor/wowjs');
    }

    ['animate.css','animate.min.css'].forEach(file =>
        fs.copySync (
            `node_modules/animate.css/${file}`,
            `vendor/animate/${file}`
        )
    );

    ['wow.js','wow.min.js'].forEach(file =>
        fs.copySync (
            `node_modules/wowjs/dist/${file}`,
            `vendor/wowjs/${file}`
        )
    );
});
