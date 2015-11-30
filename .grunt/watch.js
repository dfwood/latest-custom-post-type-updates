// https://github.com/gruntjs/grunt-contrib-watch
module.exports = {
    js: {
        files: [
            '<%= js.watch %>'
        ],
        tasks: [
            'build:js'
        ]
    },
    scss: {
        files: [
            '<%= scss.watch %>'
        ],
        tasks: [
            'build:css'
        ]
    }
};
