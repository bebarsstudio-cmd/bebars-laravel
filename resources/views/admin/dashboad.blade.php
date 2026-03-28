@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-container">
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-newspaper"></i>
                <div class="stat-number">{{ $stats['news_count'] }}</div>
                <div class="stat-label">Total News</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-project-diagram"></i>
                <div class="stat-number">{{ $stats['projects_count'] }}</div>
                <div class="stat-label">Projects</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-comments"></i>
                <div class="stat-number">{{ $stats['feedback_count'] }}</div>
                <div class="stat-label">Feedback</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-heart"></i>
                <div class="stat-number">{{ $stats['votes']['total'] }}</div>
                <div class="stat-label">Total Votes</div>
            </div>
        </div>
        
        <div class="admin-section">
            <h2>Recent News</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentNews as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->date->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn-sm">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="admin-actions">
            <a href="{{ route('admin.news.create') }}" class="btn-primary">Add News</a>
            <a href="{{ route('admin.admins.index') }}" class="btn-secondary">Manage Admins</a>
        </div>
    </div>
</div>
@endsection