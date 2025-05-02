rm -rf vendor && \
rm -rf node_modules && \
rm -f database/*sqlite* && \
rm -f /Users/andrea/Servers/imet_offline_DEV/storage/logs/*.log && \
rm -rf "/Users/andrea/Library/Application Support/imet-offline-dev/" && \
composer install && \
npm install && \
touch database/offline.sqlite && \
php artisan migrate --seed && \
php artisan native:install --force && \
php artisan native:migrate && \
php artisan native:serve

