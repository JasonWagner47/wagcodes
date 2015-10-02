var gulp = require('gulp'),
	watch = require('gulp-watch'),
	del = require('del'),

	// Javascript linting and minification
	eslint = require('gulp-eslint'),
	uglify = require('gulp-uglify'),

	// Move Bower main files
	bower = require('main-bower-files'),

	// SCSS
	compass = require('gulp-compass'),
	autoprefixer = require('gulp-autoprefixer'),

	// ImageOptim
	imageOptim = require('gulp-imageoptim'),

	// SVG minification
	svgmin = require('gulp-svgmin');

// Single-use Gulp build task
gulp.task('build', ['fonts', 'scss', 'js', 'img', 'bower', 'svg']);

// Watch build task
gulp.task('watch', function() {
	// move bower components
	gulp.watch('bower_components/**/*', ['bower']);

	// minify and move JavaScript
	gulp.watch('src/js/**/*.js', ['js']);

	// move fonts
	gulp.watch('src/fonts/**/*', ['fonts']);

	// compile and move SCSS
	gulp.watch('src/scss/**/*.scss', ['scss']);

	// optimize and move images
	gulp.watch('src/img/**/*', ['img']);

	// optimize and move svg
	gulp.watch('src/svg/**/*', ['svg']);
});

gulp.task('clean', function() {
	return del([
		'build/**/*'
	]);
});

gulp.task('scss', function() {
	gulp.src('src/scss/**/*.scss')
		.pipe(compass({
			config_file: 'src/config.rb',
			css: 'build/css',
			sass: 'src/scss',
			sourcemap: true,
		}))
		.on('error', function(error) {
			console.log(error);
			this.emit('end');
		})
		.pipe(gulp.dest('build/css'));

	gulp.src('src/fonts/**/*')
		.pipe(gulp.dest('build/fonts'));
});

gulp.task('fonts', function() {
	return gulp.src('src/fonts/**/*')
		.pipe(gulp.dest('build/fonts'));
});

gulp.task('js' ,function() {
	return gulp.src(['src/js/**/*.js'])
		.pipe(eslint())
		.pipe(eslint.format())
		.pipe(uglify({mangle:false}))
		.on('error', function(error) {
			console.log(error);
			this.emit('end');
		})
		.pipe(gulp.dest('build/js'));
});

gulp.task('svg', function() {
	return gulp.src('src/svg/**/*')
		.pipe(gulp.dest('build/svg'));
});

gulp.task('bower', function() {
	return gulp.src(bower())
		.pipe(uglify({mangle:false}))
		.pipe(gulp.dest('build/js/vendor'));
});

gulp.task('img', function() {
	return gulp.src('src/img/**/*')
		.pipe(imageOptim.optimize())
		.pipe(gulp.dest('build/img'));
});
