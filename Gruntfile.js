
module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
      pkg: grunt.file.readJSON('package.json'),
      ngtemplates:  {
        app:        {
          src:      ['public/templates/**.html', 'public/templates/parts/**.html'],
          dest:     'js/src/modules/angular/backend//dist/template.js',
          options:  {
            url:    function(url) { 
              url = url.replace('public/templates/', 'https://vtex-static.herokuapp.com/templates/');
              return url;
            }
          }
        }
      },
      uglify: {
        options: {
          compress: {},
          mangle: {
            except: ['jQuery', 'angular']
          }
        },
        build: {
          files: {
            "js/dist/backend.js" : [
              'js/src/modules/angular/backend/services.js',
              'js/src/modules/angular/backend/app/*.js',
              'js/src/modules/angular/backend/main.js'
            ]//end files
          }
        }
      },
      less: {
        build: {
          files: {
            "css/style.css" : [
              "css/less/style.less"
            ]
          }
        }
      },
      cssmin: {
        combine: {
          files: {
            "css/style.css" : "css/style.css"
          }
        }
      },
      inlinecss: {
        main: {
            options: {
            },
            files: {
              'emails/dist/email_cortesia_contacto_en.html': ['emails/dist/email_cortesia_contacto_en.html'],
              'emails/dist/email_cortesia_contacto_pt.html': ['emails/dist/email_cortesia_contacto_pt.html'],
              'emails/dist/email_dados_contacto.html': ['emails/dist/email_dados_contacto.html']
            }
        }
    },
    includereplace: {
      dist: {
        options: {
          globals: {
            var1: 'one',
            var2: 'two',
            var3: 'three'
          },
        },
        files: {
          'emails/dist/email_cortesia_contacto_en.html': ['emails/dev/email_cortesia_contacto_en.html'],
          'emails/dist/email_cortesia_contacto_pt.html': ['emails/dev/email_cortesia_contacto_pt.html'],
          'emails/dist/email_dados_contacto.html': ['emails/dev/email_dados_contacto.html']
        }
      }
    }
    });
  
  
    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-angular-templates');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.loadNpmTasks('grunt-inline-css');
    grunt.loadNpmTasks('grunt-include-replace');
  
    // Default task(s).
    //grunt.registerTask('css', ['less', 'cssmin', 'autoprefixer']);
    grunt.registerTask('def', ['uglify', 'less', 'cssmin']);
    grunt.registerTask('email', ['less', 'includereplace', 'inlinecss']);
  
  };