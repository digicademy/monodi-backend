#
# Production
#
set :domain,      "adwserv9.adwmainz.net"
set :deploy_to,   "/var/www/vhosts/monodi.corpus-monodicum.de/symfony2"

set :user,          "petzold"
set :port,          "7022"
ssh_options[:port] = 7022
#ssh_options[:forward_agent] = true
ssh_options[:keys] = %w(../../../ssh/petzold_id_rsa)
set :rsync_ssh_options, "-i ../../../ssh/petzold_id_rsa"

# APC-Config
apc_webroot = "/#{web_path}"
url_base = "https://monodi.corpus-monodicum.de"

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
    desc "-- SSH-KeyFile-Rechte setzen fuer Zugriff des Webservers"
    task :enable do
      puts "Rechte setzen fuer Zugriff"
      try_sudo "chmod 600 #{latest_release}/#{app_path}/config/ssh/*" # && chown -R www-data:www-data #{latest_release}/#{app_path}/config/ssh/webserver.rsa"
    end
  end

  # https://gist.github.com/real34/2972726
  namespace :apc do
  	desc <<-DESC
  		Create a temporary PHP file to clear APC cache, call it (using curl) and removes it
  		This task must be triggered AFTER the deployment to clear APC cache
  	DESC
  	task :clear_cache, :roles => :app do
  		apc_file = "#{current_release}#{apc_webroot}/apc_clear.php"
  		curl_options = "-s"
  		wget_options = "-q --spider"
  		if (defined? http_auth_users) != nil && !http_auth_users.to_a.empty? then
  			curl_options = curl_options + " --user " + http_auth_users[0][0] + ":" + http_auth_users[0][1]
  		end

  		put "<?php apc_clear_cache(); apc_clear_cache('user'); ?>", apc_file, :mode => 0644
  		#try_sudo "curl #{curl_options} #{url_base}/apc_clear.php && rm -f #{apc_file}"
  		try_sudo "wget #{wget_options} #{url_base}/apc_clear.php && rm -f #{apc_file}"
  	end
  end

end

#after 'deploy:update_code', 'monodi:ssh:enable'
after 'deploy:finalize_update', 'symfony:project:clear_controllers'
before 'deploy:restart', 'monodi:apc:clear_cache'