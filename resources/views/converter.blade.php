@extends('layouts.app')

@section('title', 'Image to WebP Converter')

@section('content')
<div class="container">
    <div class="converter-container">
        <h1>Image to WebP Converter</h1>
        <p>Convert your images to WebP format for better web performance</p>
        
        <form id="converterForm" action="{{ route('converter.convert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn-primary">Convert to WebP</button>
        </form>
        
        <div id="result" style="margin-top: 20px;"></div>
    </div>
</div>

<style>
    .converter-container {
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
    input[type="file"] {
        padding: 10px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        color: white;
    }
</style>

<script>
    document.getElementById('converterForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const response = await fetch('{{ route('converter.convert') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        if (response.ok) {
            const blob = await response.blob();
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'converted.webp';
            a.click();
            URL.revokeObjectURL(url);
        } else {
            alert('Conversion failed!');
        }
    });
</script>
@endsection