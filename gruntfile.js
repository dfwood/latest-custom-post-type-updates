module.exports = function (grunt) {
    // The following paths may be edited
    var js = {
        uglify: {
            //'dest': 'src'
            'js/tm-lcptu-admin.min.js': 'js/tm-lcptu-admin.js'
        },
        watch: ['js/tm-lcptu-admin.js']
    };
    var css = {
        dest: {
            dev: 'css/tm-lcptu-admin.css',
            min: 'css/tm-lcptu-admin.min.css'
        }
    };
    var scss = {
        main: 'css/scss/main-admin.scss',
        watch: ['css/scss/**/*.scss']
    };

    /** STOP EDITING! **/
    var path = require('path');
    require('load-grunt-config')(grunt, {
        configPath: path.join(process.cwd(), '.grunt'),
        init: true,
        data: {
            js: js,
            css: css,
            scss: scss
        }
    });
};
