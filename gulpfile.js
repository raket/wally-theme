'use strict';

var gulp       = require('gulp'),
	bowerFiles = require('main-bower-files'),
	path       = require('path'),
	open       = require('open'),
	fs         = require('fs'),
	chalk      = require('chalk'),
	args       = require('yargs').argv,
	map        = require('map-stream'),
	runSequence = require('run-sequence'),
    sourcemaps = require('gulp-sourcemaps'),
    livereload = require('gulp-livereload'),
    gulpPlugins = require('gulp-load-plugins')(),
	autoprefixer = require('gulp-autoprefixer'),
	wiredep = require('wiredep').stream;

// chalk config
var errorLog  = chalk.red.bold,
	hintLog   = chalk.blue,
	changeLog = chalk.red;

var themeName = 'wally-theme';
var themePath = '';

var	SETTINGS = {
    app: {
        name: themeName
    },
	src: {
		app:        themePath,
		css:        themePath + 'assets/sass/',
		js:         themePath + 'assets/js/',
		images:     themePath + 'assets/images/',
		fonts:      themePath + 'assets/fonts/',
		bower:      themePath + 'assets/bower/'
	},
	build: {
		app:        themePath,
		css:        themePath + 'assets/css/',
		js:         themePath + 'assets/js/build/',
		images:     themePath + 'assets/images/',
		fonts:      themePath + 'assets/fonts/',
		bower:      themePath + 'assets/bower/'
	},
	scss: 'scss/'
};

var bowerConfig = {
    debugging: true,
    paths: {
		bowerDirectory: SETTINGS.src.bower,
		bowerrc: '.bowerrc',
		bowerJson: 'bower.json'
	}
};

// jsHint Options.
var hintOptions = JSON.parse(fs.readFileSync('.jshintrc', 'utf8'));

// Flag for generating production code.
var isProduction = args.type === 'production';

gulp.task('tasks', gulpPlugins.taskListing);

/*============================================================
=                          Concat                           =
============================================================*/

gulp.task('concat', ['concat:bower', 'concat:js', 'concat:css']);

gulp.task('concat:bower', function () {
	console.log('-------------------------------------------------- CONCAT :bower');

	var jsFilter = gulpPlugins.filter('**/*.js', {restore: true}),
		cssFilter = gulpPlugins.filter('**/*.css', {restore: true}),
		assetsFilter = gulpPlugins.filter(['!**/*.js', '!**/*.css', '!**/*.scss'], {restore: true});

	var stream = gulp.src(bowerFiles(bowerConfig), {base: SETTINGS.src.bower})
		.pipe(jsFilter)
		.pipe(gulpPlugins.concat('_bower.js'))
		.pipe(gulpPlugins.if(isProduction, gulpPlugins.uglify()))
		.pipe(gulp.dest(SETTINGS.build.bower))
		.pipe(jsFilter.restore)
		.pipe(cssFilter)
		.pipe(gulpPlugins.sass())
		.pipe(map(function (file, callback) {
			var relativePath = path.dirname(path.relative(path.resolve(SETTINGS.src.bower), file.path));

			// CSS path resolving
			// Taken from https://github.com/enyojs/enyo/blob/master/tools/minifier/minify.js
			var contents = file.contents.toString().replace(/url\([^)]*\)/g, function (match) {
				// find the url path, ignore quotes in url string
				var matches = /url\s*\(\s*(('([^']*)')|("([^"]*)")|([^'"]*))\s*\)/.exec(match),
					url = matches[3] || matches[5] || matches[6];

				// Don't modify data and http(s) urls
				if (/^data:/.test(url) || /^http(:?s)?:/.test(url)) {
					return 'url(' + url + ')';
				}
				return 'url(' + path.join(path.relative(SETTINGS.build.bower, SETTINGS.build.app), SETTINGS.build.bower, relativePath, url) + ')';
			});
			file.contents = new Buffer(contents);

			callback(null, file);
		}))
		.pipe(gulpPlugins.concat('_bower.css'))
		.pipe(gulp.dest(SETTINGS.build.bower))
		.pipe(cssFilter.restore)
		.pipe(assetsFilter)
		.pipe(gulp.dest(SETTINGS.build.bower))
		.pipe(assetsFilter.restore)
        .pipe(livereload());
	return stream;
});

gulp.task('concat:js', [], function () {

	console.log('-------------------------------------------------- CONCAT :js');
	gulp.src([
		SETTINGS.src.js + 'vendor/*.js',
		SETTINGS.src.js + '*.js',
		SETTINGS.src.js + 'app.js'
	])
	    .pipe(gulpPlugins.concat('all.js'))
	    .pipe(gulpPlugins.if(isProduction, gulpPlugins.uglify()))
	    .pipe(gulp.dest(SETTINGS.build.js))
        .pipe(livereload());
});

gulp.task('convert:themes', function () {
	console.log('-------------------------------------------------- COVERT - scss');

	// Callback to show sass error
	var showError = function (err) {
		console.log(errorLog('\n SASS file has error clear it to see changes, see below log ------------->>> \n'));
		console.log(err.toString());
		this.emit('end');
	};

	return gulp.src(SETTINGS.src.css + 'themes/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(gulpPlugins.sass({
			includePaths: [
				SETTINGS.src.css,
				SETTINGS.src.bower
			]
		})).on('error', showError)
		.pipe(autoprefixer({
			browsers: ['last 3 versions'],
			cascade: false,
			remove: true
		}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(SETTINGS.build.css + 'themes/'))
		.pipe(livereload());

});


gulp.task('convert:scss', function () {
	console.log('-------------------------------------------------- COVERT - scss');

	// Callback to show sass error
	var showError = function (err) {
		console.log(errorLog('\n SASS file has error clear it to see changes, see below log ------------->>> \n'));
        console.log(err.toString());
        this.emit('end');
	};

    return gulp.src(SETTINGS.src.css + 'app.scss')
        .pipe(sourcemaps.init())
        .pipe(gulpPlugins.sass({
            includePaths: [
                SETTINGS.src.css,
                SETTINGS.src.bower
            ]
        })).on('error', showError)
		.pipe(autoprefixer({
			browsers: ['last 3 versions'],
			cascade: false,
			remove: true
		}))
        .pipe(sourcemaps.write())
       .pipe(gulp.dest(SETTINGS.build.css))
       .pipe(livereload());
});

gulp.task('concat:css', ['convert:scss', 'convert:themes'], function () {

	console.log('-------------------------------------------------- CONCAT :css ');
	gulp.src([
            SETTINGS.build.css + 'app.css',
            //SETTINGS.src.css + '*.css'
        ])
	    .pipe(gulpPlugins.concat('app.css'))
	    .pipe(gulpPlugins.if(isProduction, gulpPlugins.minifyCss({keepSpecialComments: '*'})))
	    .pipe(gulp.dest(SETTINGS.build.css))
        .pipe(livereload());
});

gulp.task('reload', function () {
    console.log('-------------------------------------------------- RELOAD');
    livereload();
});

gulp.task('copy', function () {
    console.log('-------------------------------------------------- COPY :icons');
    gulp.src([SETTINGS.src.bower + '/fontawesome/fonts/**.*'])
        .pipe(gulp.dest(SETTINGS.build.bower + '/fontawesome/fonts'));
});

/*=========================================================================================================
=												Watch

	Incase the watch fails due to limited number of watches available on your sysmtem, the execute this
	command on terminal

	$ echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p
=========================================================================================================*/
	
gulp.task('watch', function () {
	
	console.log('watching all the files.....');
    livereload.listen();

	var watchedFiles = [];

	watchedFiles.push(gulp.watch([SETTINGS.src.css + '*.css',  SETTINGS.src.css + '**/*.css'],  ['concat:css']));
	
	watchedFiles.push(gulp.watch([SETTINGS.src.css + '*.scss', SETTINGS.src.css + '**/*.scss'], ['concat:css']));

    watchedFiles.push(gulp.watch([SETTINGS.src.js + '*.js',    SETTINGS.src.js + '**/*.js'],    ['concat:js']));

	watchedFiles.push(gulp.watch([SETTINGS.src.bower + '*.js', SETTINGS.src.bower + '**/*.js'], ['concat:bower']));

    watchedFiles.push(gulp.watch([SETTINGS.src.partials + '*.html', SETTINGS.src.partials + '**/*.html'], ['concat:partials']));

	// Just to add log messages on Terminal, in case any file is changed
	var onChange = function (event) {
		if (event.type === 'deleted') {
			setTimeout(function () {
				runSequence( 'concat', 'watch');
			}, 500);
		}
		console.log(changeLog('-------------------------------------------------->>>> File ' + event.path + ' was ------->>>> ' + event.type));
	};

	watchedFiles.forEach(function (watchedFile) {
		watchedFile.on('change', onChange);
	});
    //
    //var server = livereload();
    //gulp.watch([SETTINGS.src.templates + '*.php', SETTINGS.src.templates + '**/*.php']).on('change', function(file) {
    //    server.changed(file.path);
    //    util.log(util.colors.yellow('PHP file changed' + ' (' + file.path + ')'));
    //});
	
});

/*============================================================
 =                          Wiredep                          =
 ============================================================*/

gulp.task('wiredep', function () {
	gulp.src(SETTINGS.src.css + 'app.scss')
		.pipe(wiredep())
		.pipe(gulp.dest(SETTINGS.src.css));
});

/*============================================================
=                             Start                          =
============================================================*/

gulp.task('build', function () {
	console.log(hintLog('-------------------------------------------------- BUILD - Development Mode'));
	runSequence('concat', 'copy', 'watch');
});

gulp.task('build:prod', function () {
	console.log(hintLog('-------------------------------------------------- BUILD - Production Mode'));
	isProduction = true;
	runSequence('concat', 'watch');
});

gulp.task('default', ['build']);

// Just in case you are too lazy to type: $ gulp --type production
gulp.task('prod', ['build:prod']);