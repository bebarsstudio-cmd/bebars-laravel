#!/bin/bash

echo "🔧 Fixing game_scores table..."

# Check if migration exists
if [ ! -f database/migrations/*_create_game_scores_table.php ]; then
    echo "Creating migration..."
    php artisan make:migration create_game_scores_table
fi

# Run migration
echo "Running migration..."
php artisan migrate

# Clear cache
echo "Clearing cache..."
php artisan optimize:clear

# Dump autoload
echo "Dumping autoload..."
composer dump-autoload

echo "✅ Done!"
echo "Visit: http://localhost:8000/boba"
