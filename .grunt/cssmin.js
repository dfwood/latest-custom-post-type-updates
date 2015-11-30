// https://github.com/gruntjs/grunt-contrib-cssmin
module.exports = {
    plugin: {
        files: {
            '<%= css.dest.min %>': ['<%= css.dest.dev %>']
        }
    }
};
