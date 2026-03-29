@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="hero-section">
        <h1>Welcome to BEBARS-GAMING</h1>
        <p>Your ultimate gaming and development hub!</p>
        
        <div class="game-links">
            <a href="{{ url('/boba') }}" class="btn-primary">
                <i class="fas fa-gamepad"></i> Play Boba Game
            </a>
            <a href="{{ url('/converter') }}" class="btn-secondary">
                <i class="fas fa-image"></i> Image Converter
            </a>
            <a href="{{ url('/youtube') }}" class="btn-secondary">
                <i class="fab fa-youtube"></i> YouTube Downloader
            </a>
        </div>
    </div>

    <!-- News Section -->
    <div class="news-section">
        <h2 class="section-title">Latest <span>News</span></h2>
        <div class="news-grid">
            @forelse($news as $item)
                <div class="news-card">
                    <div class="news-date">{{ $item->created_at->format('M d, Y') }}</div>
                    <h3>{{ $item->title }}</h3>
                    <p>{{ Str::limit($item->content, 100) }}</p>
                </div>
            @empty
                <div class="empty-state">
                    <p>No news yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Projects Section -->
    <div class="projects-section">
        <h2 class="section-title">My <span>Projects</span></h2>
        <div class="projects-grid">
            @forelse($projects as $project)
                <div class="project-card">
                    <h3>{{ $project->title }}</h3>
                    <p>{{ Str::limit($project->description, 100) }}</p>
                    @if($project->technologies)
                        <div class="project-tech">
                            @foreach($project->technologies as $tech)
                                <span>{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <p>No projects yet. Coming soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
    .hero-section { text-align: center; padding: 60px 20px; }
    .hero-section h1 { font-size: 3rem; margin-bottom: 20px; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .game-links { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 40px; }
    .btn-primary, .btn-secondary { padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: transform 0.3s; display: inline-flex; align-items: center; gap: 10px; }
    .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
    .btn-secondary { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; }
    .btn-primary:hover, .btn-secondary:hover { transform: translateY(-2px); }
    .section-title { font-size: 2rem; text-align: center; margin: 60px 0 30px; }
    .section-title span { background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .news-grid, .projects-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
    .news-card, .project-card { background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; transition: transform 0.3s; }
    .news-card:hover, .project-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.08); }
    .news-date { color: #667eea; font-size: 0.8rem; margin-bottom: 10px; }
    .project-tech { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 15px; }
    .project-tech span { background: rgba(102,126,234,0.2); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; color: #667eea; }
    .empty-state { text-align: center; padding: 40px; color: #888; }
</style>
@endsection
