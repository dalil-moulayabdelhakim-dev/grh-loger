# deploy.sh
echo "Deployment started..."

# Enter maintenance mode
php artisan down || true

# Install dependencies (if composer is available on server)
# composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Clear and cache config/routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
