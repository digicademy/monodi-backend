#
# http://capifony.org/
#
set :application, "Monodi-Backend"
set :domain,      "adwserv9.adwmainz.net"
set :deploy_to,   "/var/www/vhosts/adwserv9.adwmainz.net/"
set :app_path,    "app"

set :repository,  "git@bitbucket.org:digitalwert/monodi-backend.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`
set :deploy_via, :rsync_with_remote_cache

set :ssh_options[:port], "7022"

# Symfony2
set :use_composer, true
#set :update_vendors, true

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,  10

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL