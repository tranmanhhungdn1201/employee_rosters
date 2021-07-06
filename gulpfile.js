const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
// const browserSync = require('browser-sync').create();

// compiler scss to css
function style() {
    // where is my scss files
    return gulp.src('./resources/sass/**/*.scss')
    // pass that file throught sass compiler
    .pipe(sass())
    // where do I save css files
    .pipe(gulp.dest('./public/css'));
    // .pipe(browserSync.stream());
}

function watch() {
    // browserSync.init({
    //     // server: {
    //     //     baseDir: './'
    //     // },
    //     proxy: 'http://127.0.0.1:8000',
    // });

    gulp.watch('./resources/sass/**/*.scss', style);
    // gulp.watch('./views/*blade.php').on('change', browserSync.reload);
    // gulp.watch('./resources/js/*.js', browserSync.reload);
}
exports.style = style;
exports.watch = watch;