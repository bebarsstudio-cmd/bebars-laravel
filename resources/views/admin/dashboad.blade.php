@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-container">
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-newspaper"></i>
                <div class="stat-number">{{ $stats['news_count'] ?? 0 }}</div>
                <div class="stat-label">Total News</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-project-diagram"></i>
                <div class="stat-number">{{ $stats['projects_count'] ?? 0 }}</div>
                <div class="stat-label">Projects</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-comments"></i>
                <div class="stat-number">{{ $stats['feedback_count'] ?? 0 }}</div>
                <div class="stat-label">Feedback</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-gamepad"></i>
                <div class="stat-number">{{ $stats['game_scores'] ?? 0 }}</div>
                <div class="stat-label">Game Scores</div>
            </div>
        </div>
        
        <div class="admin-actions">
            <a href="{{ route('admin.news.index') }}" class="btn-primary">Manage News</a>
            <a href="{{ route('admin.projects.index') }}" class="btn-primary">Manage Projects</a>
            <a href="{{ route('admin.admins.index') }}" class="btn-primary">Manage Admins</a>
            <a href="{{ route('admin.feedback.index') }}" class="btn-secondary">View Feedback</a>
        </div>
    </div>
</div>

<style>
    .admin-container {
        padding: 40px 0;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }
    .stat-card {
        background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1));
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .stat-card i {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 10px;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        margin: 10px 0;
    }
    .stat-label {
        color: #aaa;
    }
    .admin-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 30px;
    }
</style>
@endsection