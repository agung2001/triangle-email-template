# Deployment to Wordpress Plugin Directory
* SVN add untracked files : `svn st "$Resources" | grep '^?' | sed 's_^?       \(.*\)$_svn add "\1"_g' | sh`
* SVN remove inexists files : `svn st "$Resources" | grep '^!' | sed 's_^!       \(.*\)$_svn rm --keep-local  "\1"_g' | sh`
* Checkin Commit : `svn ci -m "branch: messages"`

# References 
* [Wordpress/Subversion](https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion) - Wordpress subversion documentation
* [Stackoverflow](https://stackoverflow.com/questions/10667973/suppress-file-does-not-exist-error-of-svn-remove) - Suppress “file does not exist” error of svn remove