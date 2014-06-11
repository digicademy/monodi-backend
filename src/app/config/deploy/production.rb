#
# Production
#
set :domain,      "adwserv9.adwmainz.net"
set :deploy_to,   "/var/www/vhosts/monodi.corpus-monodicum.de/symfony2"

set :user,          "petzold"
set :port,          "7022"
ssh_options[:port] = 7022

set :shared_children,   [app_path + "/logs", web_path + "/uploads", "vendor", "git", web_path + "/status", web_path + "/dbmgm", app_path + "/config/ssh", web_path + "/sqladmin"]
set :shared_files,      [ web_path + "/.htaccess", app_path + "/config/parameters.yml"]

role :web,        "#{domain}:7022"                         # Your HTTP server, Apache/etc
role :app,        "#{domain}:7022"               # This may be the same as your `Web` server
role :db,         "#{domain}:7022", :primary => true       # This is where Symfony2 migrations will run

server "#{domain}:7022", :app, :web, :primary => true


#mopa:bootstrap:symlink:sass

desc "Spezielle Monodi SSH"
namespace :monodi do
  
  namespace :ssh do
    desc "-- SSH-KeyFile-Rechte setzen für Zugriff des Webservers"
    task :enable do
      puts "Rechte setzen für Zugriff"
      try_sudo "chmod 600 #{latest_release}/#{app_path}/config/ssh/*" # && chown -R www-data:www-data #{latest_release}/#{app_path}/config/ssh/webserver.rsa"
    end
  end

end

#after 'deploy:update_code', 'monodi:ssh:enable'
after 'deploy:finalize_update', 'symfony:project:clear_controllers'