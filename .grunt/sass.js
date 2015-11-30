// https://github.com/gruntjs/grunt-contrib-sass
module.exports = {
    plugin: {
        options: {
            style: 'expanded',
            lineNumbers: true
        },
        src: [
            '<%= scss.main %>'
        ],
        dest: '<%= css.dest.dev %>'
    }
};
