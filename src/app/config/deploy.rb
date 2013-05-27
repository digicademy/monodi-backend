#
# http://capifony.org/
#
set :application, "Monodi-Backend"
set :domain,      "adwserv9.adwmainz.net"
set :deploy_to,   "/var/www/vhosts/adwserv9.adwmainz.net/symfony2"
set :app_path,    "src/app"
set :web_path,    "src/web"

set :repository,  "git@bitbucket.org:digitalwert/monodi-backend.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :deploy_via,  :rsync_with_remote_cache
set :copy_exclude, [ '.git' ]

#set :local_cache, ".rsync_cache"

# kein sudo verwenden
set :use_sudo, false

# SSH Settings
set :webserver_user,    "www-data"
set :user,              "petzold"
set :port,              "7022"

#ssh_options[:port] = 7022

# Symfony2
set :use_composer, true
#set :update_vendors,   true

set :shared_children,   [app_path + "/logs", web_path + "/uploads"]
# , "vendor"
#set :shared_files,      [app_path + "/config/parameters.yml"]

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        "#{domain}:7022"               # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,  10

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL