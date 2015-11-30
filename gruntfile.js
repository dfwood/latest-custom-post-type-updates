module.exports = function (grunt) {
    // The following paths may be edited
    var js = {
        uglify: {
            //'dest': 'src'
            'js/tm-lcptu-admin-options.min.js': 'js/tm-lcptu-admin-options.js'
        },
        watch: ['js/**/*.js']
    };
    /*var css = {
        dest: {
            dev: 'css/tm-lcptu.css',
            min: 'css/tm-lcptu.min.css'
        }
    };
    var scss = {
        main: 'css/scss/main.scss',
        watch: ['css/scss/!**!/!*.scss']
    };*/

    /** STOP EDITING! **/
    var path = require('path');
    require('load-grunt-config')(grunt, {
        configPath: path.join(process.cwd(), '.grunt'),
        init: true,
        data: {
            js: js/*,
            css: css,
            scss: scss*/
        }
    });
};
