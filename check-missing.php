<?php
// Save this file in the root of your Laravel project: /home/bebarsahmed/Documents/projects/bebars-gaming/check-missing.php

echo "🔍 Checking for missing files and classes...\n\n";

$paths = [
    // Controllers
    'app/Http/Controllers/HomeController.php',
    'app/Http/Controllers/GameController.php',
    'app/Http/Controllers/ConverterController.php',
    'app/Http/Controllers/YoutubeController.php',
    'app/Http/Controllers/FeedbackController.php',
    'app/Http/Controllers/Admin/DashboardController.php',
    'app/Http/Controllers/Admin/NewsController.php',
    'app/Http/Controllers/Admin/ProjectController.php',
    'app/Http/Controllers/Admin/AdminController.php',
    'app/Http/Controllers/Admin/FeedbackController.php',
    
    // Models
    'app/Models/User.php',
    'app/Models/News.php',
    'app/Models/Project.php',
    'app/Models/Like.php',
    'app/Models/Feedback.php',
    'app/Models/GameScore.php',
    
    // Views
    'resources/views/home.blade.php',
    'resources/views/boba.blade.php',
    'resources/views/converter.blade.php',
    'resources/views/youtube/downloader.blade.php',
    'resources/views/admin/dashboard.blade.php',
    
    // Middleware
    'app/Http/Middleware/AdminMiddleware.php',
];

echo "📁 Checking files:\n";
foreach ($paths as $path) {
    if (file_exists($path)) {
        echo "  ✅ " . $path . "\n";
    } else {
        echo "  ❌ " . $path . " - MISSING\n";
    }
}

echo "\n📊 Checking database tables:\n";
try {
    $db = new SQLite3('database/database.sqlite');
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = [];
    while ($row = $result->fetchArray()) {
        $tables[] = $row['name'];
    }
    
    $expectedTables = ['users', 'news', 'projects', 'feedback', 'game_scores', 'cache', 'sessions'];
    foreach ($expectedTables as $table) {
        if (in_array($table, $tables)) {
            echo "  ✅ $table\n";
        } else {
            echo "  ❌ $table - MISSING\n";
        }
    }
} catch (Exception $e) {
    echo "  ⚠️ Could not check database: " . $e->getMessage() . "\n";
}

echo "\n🎮 Boba game endpoint: " . url('/boba') . "\n";
echo "📊 Leaderboard API: " . url('/api/leaderboard') . "\n";
echo "💾 Save score API: " . url('/api/save-score') . "\n";