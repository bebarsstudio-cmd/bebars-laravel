#!/bin/bash

echo "🧹 Cleaning up ALL migrations..."

# Remove ALL migration files
rm -f database/migrations/*.php

echo "✅ All migrations removed"

# Create fresh migrations
echo "📦 Creating fresh migrations..."

# Laravel default migrations
php artisan migrate:install

# Create our custom migrations
php artisan make:migration create_news_table
php artisan make:migration create_projects_table
php artisan make:migration create_game_scores_table

echo "✅ New migrations created"
echo ""
echo "📝 Now manually add the schema to these files:"
echo "   - create_news_table.php"
echo "   - create_projects_table.php"
echo "   - create_game_scores_table.php"
echo ""
echo "Then run: php artisan migrate:fresh --seed"