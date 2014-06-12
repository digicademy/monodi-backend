Digitalwert Monodi Projekt
==========================

API-DOC befindet sich hier

== Vorbereitung ==

gems/capistrano_rsync_with_remote_cache-2.4.0/lib/capistrano/recipes/deploy/strategy/rsync_with_remote_cache.rb

durch ./src/app/config/deploy/﻿remote_cache.rb ersetzen

== Deployment ==

cap production deploy

cap production deploy:migrations

migration ohne deploy durchführen

cap production symfony:doctrine:migrations:migrate

fixures laden

cap testing symfony:doctrine:load_fixtures

