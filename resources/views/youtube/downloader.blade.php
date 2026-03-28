@extends('layouts.app')

@section('title', 'YouTube Downloader')

@section('content')
<div class="container">
    <div class="youtube-container">
        <h1>YouTube Downloader</h1>
        <p>Download videos from YouTube in high quality</p>
        
        <form action="{{ route('youtube.download') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="url" name="url" placeholder="Enter YouTube URL" required>
            </div>
            <div class="form-group">
                <select name="quality">
                    <option value="best">Best Quality</option>
                    <option value="highest">Highest Quality</option>
                    <option value="bestaudio">Audio Only</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Download</button>
        </form>
        
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
    </div>
</div>

<style>
    .youtube-container {
        max-width: 600px;
        margin: 50px auto;
        text-align: center;
        padding: 40px;
        background: rgba(255,255,255,0.05);
        border-radius: 20px;
    }
    .form-group {
        margin: 20px 0;
    }
    input, select {
        width: 100%;
        padding: 12px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        color: white;
    }
    .alert-error {
        margin-top: 20px;
        padding: 10px;
        background: rgba(255,68,68,0.2);
        border: 1px solid #ff4444;
        border-radius: 10px;
        color: #ff4444;
    }
</style>
@endsection