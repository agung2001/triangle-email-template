#!/bin/sh

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"

if [ "production" == "$1" ]
    then
      # Composer build
      cd $SCRIPTPATH && /usr/local/bin/composer update
      rm -rf composer.lock
      rm -rf composer.json

      # Sass cache
      rm -rf assets/css/.sass-cache
      rm -rf style.css.map
      rm -rf assets/css/*.scss

      # Git
      rm -rf .git
      rm -rf .gitignore
      rm -rf README.md
fi