#!/bin/sh

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"

if [ "production" == "$1" ]
    then
      # Composer build
      cd $SCRIPTPATH && /usr/local/bin/composer update
      rm -rf composer.lock
      rm -rf composer.json

      # Sass
      rm -rf assets/css/backend/.sass-cache
      rm -rf assets/css/frontend/.sass-cache
      rm -rf assets/css/customizer/.sass-cache
      rm -rf assets/css/emailtemplate/.sass-cache
      rm -rf style.css.map
      rm -rf assets/css/*.scss
      rm -rf assets/css/bootstrap

      # Git
      rm -rf .git
      rm -rf .gitignore
      rm -rf README.md
fi