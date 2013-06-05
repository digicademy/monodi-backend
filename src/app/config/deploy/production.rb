#
# Production
#
set :domain,      "adwserv9.adwmainz.net"
set :deploy_to,   "/var/www/vhosts/adwserv9.adwmainz.net/symfony2"

set :user,          "petzold"
set :port,          "7022"
ssh_options[:port] = 7022

set :shared_children,   [app_path + "/logs", web_path + "/uploads", "vendor", "git", web_path + "/status", web_path + "/dbmgm"]
set :shared_files,      [ web_path + "/.htacess"]

role :web,        "#{domain}:7022"                         # Your HTTP server, Apache/etc
role :app,        "#{domain}:7022"               # This may be the same as your `Web` server
role :db,         "#{domain}:7022", :primary => true       # This is where Symfony2 migrations will run


after 'deploy:finalize_update', 'symfony:project:clear_controllers'