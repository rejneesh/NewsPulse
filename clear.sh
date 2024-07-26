#!/bin/bash
#chmod +x clear.sh
#sudo ./clear.sh
# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Clear configuration cache
php artisan config:clear

# Clear compiled views cache
php artisan view:clear

# Optimize the application (compile common classes)
php artisan optimize

# (Optional) Cache the routes for faster route registration
php artisan route:cache

# (Optional) Cache the configuration for faster config loading
php artisan config:cache

# (Optional) Optimize the autoload files
composer dump-autoload -o

echo "Laravel cache cleared and application optimized."