// https://github.com/gruntjs/grunt-contrib-uglify
module.exports = {
    js: {
        options: {
            mangle: true,
            preserveComments: 'some'
        },
        files: '<%= js.uglify %>'
    }
};
