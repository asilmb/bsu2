var gulp = require('gulp'),
	minifyCss = require('gulp-minify-css'),
	rename = require('gulp-rename'),
	autoprefixer = require('gulp-autoprefixer'),
	livereload = require('gulp-livereload'),
	connect = require('gulp-connect'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify'),
	imagemin = require('gulp-imagemin'),
	pngquant = require('imagemin-pngquant'),
	concat = require('gulp-concat'),
	merge = require('merge-stream'),
	browserSync = require('browser-sync'),
	rev = require('gulp-rev-append'),
	sourcemaps = require('gulp-sourcemaps'),
	plumber = require('gulp-plumber'),
	include = require('gulp-html-tag-include'),
	notify = require('gulp-notify');

/*production build maker*/
gulp.task('scripts', function () {
	return gulp.src(['assets/js/script.js'])
		.pipe(plumber({
			errorHandler: notify.onError(function (err) {
				return {
					title: 'JS TASK ERROR',
					message: err.message
				};
			})
		}))
		.pipe(concat('application.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('./../web/js/'))
		.pipe(browserSync.stream({mangle: false}));

});


gulp.task('html-include', function () {
	return gulp.src('./assets/pages/html/*.html')
		.pipe(include())
		.pipe(gulp.dest('./public'));
});

gulp.task('styles', function () {
	return gulp.src(['./assets/css/*.sass', '!./assets/css/mobile.sass', './assets/css/*.css', './assets/css/*.sass'])
		.pipe(plumber({
			errorHandler: notify.onError(function (err) {
				return {
					title: 'CSS TASK ERROR',
					message: err.message
				};
			})
		}))
		.pipe(sass.sync())
		.pipe(minifyCss(''))
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade: false
		}))
		.pipe(concat('style.min.css'))
		.pipe(gulp.dest('./../web/css'))
		.pipe(browserSync.stream());
});

gulp.task('styles-mobile', function () {
	return gulp.src(['./assets/css/*.sass', '!./assets/css/style.sass', './assets/css/*.css'])
		.pipe(plumber({
			errorHandler: notify.onError(function (err) {
				return {
					title: 'CSS TASK ERROR',
					message: err.message
				};
			})
		}))
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe(concat('mobile.min.css'))
		.pipe(sass.sync())
		.pipe(minifyCss(''))
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade: false
		}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./../web/css'))
		.pipe(browserSync.stream());
});


gulp.task('html', function () {
	gulp.src('public/*.html')
		.pipe(browserSync.stream());
});


gulp.task('img', function () {
	gulp.src(['assets/images/*.*', 'assets/images/**/*.*', 'assets/images/**/**/*.*'])
		.pipe(imagemin({
			progressive: true,
			svgoPlugins: [{removeViewBox: false}],
			use: [pngquant()]
		}))
		.pipe(gulp.dest('./../web/images/'))
		.pipe(browserSync.stream());
});


// Watch
gulp.task('watch', function () {
	gulp.watch("public/*.html", ['html']);
	gulp.watch("./assets/js/*.js", ['scripts']);
	gulp.watch("./assets/css/**/*.sass", ['styles']);
	gulp.watch("./assets/css/*.css", ['styles']);
	gulp.watch(['assets/pages/**/*.html', 'assets/pages/*.html'], ['html-include']);
	gulp.watch(["assets/images", "assets/images/*.*", 'assets/images/**/**', 'assets/images/**/**/*.*'], ['img']);
	gulp.watch(["public/*.html"], browserSync.reload());
});


gulp.task('browser-sync', function () {
	browserSync.init({
		server: {
			baseDir: "public"
		}
	});
});

// Default
gulp.task('default', ['html', 'scripts', 'styles', 'img', 'browser-sync', 'html-include', 'watch']);