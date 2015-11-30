// https://github.com/gruntjs/grunt-contrib-concat
module.exports = {
    'vendor-js': {
        src: [
            '<%= paths.lib.js %>'
        ],
        dest: '<%= paths.dest.lib.js %>'
    },
    js: {
        src: [
            '<%= js.concat %>'
        ],
        dest: '<%= js.dest.dev %>'
    },
    'vendor-css': {
        src: [
            '<%= paths.lib.css %>'
        ],
        dest: '<%= paths.dest.lib.css %>'
    }
};