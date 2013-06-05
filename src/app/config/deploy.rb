#
# http://capifony.org/
#
# Multistaging: http://www.zalas.eu/multistage-deployment-of-symfony-applications-with-capifony
# 
#
set :stage_dir, 'app/config/deploy' # needed for Symfony2 only
require 'capistrano/ext/multistage'
set :stages, %w(production testing development)

set :application, "Monodi-Backend"

set :app_path,    "app"
set :web_path,    "web"

set :deploy_subdir,"src/" 

set :repository,  "git@bitbucket.org:digitalwert/monodi-backend.git"
set :scm,         :git
set :branch,      "master"
set :git_enable_submodules, 1

set :deploy_via,  :rsync_with_remote_cache
set :copy_exclude, [ '.git', '.gitignore' ]

#set :local_cache, ".rsync_cache"

# kein sudo verwenden
set :use_sudo, false

# SSH Settings
set :webserver_user,    "www-data"

# Symfony2
set :use_composer, true
#set :update_vendors,   true
set :composer_options,      "--no-scripts --no-dev --verbose --optimize-autoloader"

set :assets_symlinks, true
set :console_options, "-verbose"

set :model_manager, "doctrine"
# Or: `propel`

set  :keep_releases,  10

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL