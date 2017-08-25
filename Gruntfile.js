module.exports = function(grunt) {
  const pkg = grunt.file.readJSON( 'package.json' );
  let taskName;
  for ( taskName in pkg.devDependencies ) {
    if ( taskName.substring( 0, 6 ) === 'grunt-' ) {
      grunt.loadNpmTasks( taskName );
    }
  }
  // Project configuration.
  grunt.initConfig( {
    pkg: pkg,
    connect: {
      dev: {
        options: {
          protocol: 'http',
          port: 3000,
          base: 'public'
        }
      }
    },
    compass: {
      dist: {
        options: {
          config: ['config.rb']
        }
      }
    },
    watch: {
      scss: {
        files: ['sass/lp.scss','sass/test.scss'],
        tasks: ['compass']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-connect');

  grunt.registerTask('default', ['compass','connect:dev','watch']);
};