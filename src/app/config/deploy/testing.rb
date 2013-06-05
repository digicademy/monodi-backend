#
# Testing 
#
set :symfony_env_prod, "test"

set :domain,      "notengrafik.dw-dev.de"
set :deploy_to,   "/kunden/257211_01127/var/www/de.dw-dev.notengrafik"

set :user,        "ssh-257211-root"
set :php_bin,     "/usr/local/bin/php5-54STABLE-CLI"


set :shared_children,   [app_path + "/logs", web_path + "/uploads", "vendor", "git", web_path + "/status", web_path + "/dbmgm"]
set :shared_files,      [ web_path + "/.htaccess"]

role :web,        "#{domain}"                         # Your HTTP server, Apache/etc
role :app,        "#{domain}"               # This may be the same as your `Web` server
role :db,         "#{domain}", :primary => true       # This is where Symfony2 migrations will run

# Dazu muss sass auf dem system installiert sein
#after 'symfony:assets:install', 'symfony:assetic:dump'