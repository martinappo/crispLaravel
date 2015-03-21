var gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	jshint = require('gulp-jshint'),
	uglify = require('gulp-uglify'),
	imagemin = require('gulp-imagemin'),
	rename = require('gulp-rename'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	cache = require('gulp-cache'),
	livereload = require('gulp-livereload'),
	del = require('del');
	concatCss = require('gulp-concat-css');
	watch = require('gulp-watch');
	runSequence = require('run-sequence');

gulp.task('libs', function() {
	return gulp.src([
			'resources/js/libs/jquery.js',
			'resources/js/libs/jquery-ui.js',
			'resources/js/libs/jquery.mobile.js',
			'resources/js/libs/bootstrap.js',
			'resources/js/libs/angular.js',
			'resources/js/libs/angular-file-upload.min.js',
			'resources/js/libs/angular-ui-sortable.js',
			])
		.on('error', function(err) {
			console.error('Error!', err.message);
		})
		.pipe(concat('libs.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify({mangle: false}))
		.pipe(gulp.dest('public/js'))
		.pipe(notify({ message: 'Scripts libs task complete' }));
});

gulp.task('scripts', function() {
	return gulp.src([
			'resources/js/controllers/*.js',
			'resources/js/services/*.js',
			'resources/js/app.js',
			])
		.on('error', function(err) {
			console.error('Error!', err.message);
		})
		.pipe(concat('scripts.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify({mangle: false}))
		.pipe(gulp.dest('public/js'))
		.pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('sass', function() {
	return sass('resources/sass/')
	.on('error', function(err) {
		console.error('Error!', err.message);
	})
	.pipe(gulp.dest('resources/css'));
});

gulp.task('css', function() {
	return gulp.src([
			'resources/css/jquery-ui-structure.min.css',
			'resources/css/bootstrap.css',
			'resources/css/style.css',
		])
	.on('error', function(err) {
		console.error('Error!', err.message);
	})
	.pipe(concatCss('all.min.css'))
	.pipe(minifycss())
	.pipe(gulp.dest('public/css'));
});

gulp.task('styles', function() {
	runSequence('sass','css');
});

gulp.task('watchstyles', function () {
	gulp.watch('resources/sass/*.scss', ['styles']);
});

gulp.task('watchscripts', function () {
	gulp.watch(['resources/js/*.js', 'resources/js/controllers/*.js', 'resources/js/services/*.js'], ['scripts']);
});

gulp.task('watch', function () {
	gulp.watch(['resources/js/*.js', 'resources/js/controllers/*.js', 'resources/js/services/*.js', 'resources/sass/*.scss'], ['scripts', 'styles']);
});


gulp.task('default', ['scripts', 'sass', 'css']);