// https://github.com/gruntjs/grunt-concurrent
module.exports = {
    run: {
        tasks: ['build', 'watch'],
        options: {
            logConcurrentOutput: true
        }
    }
};