<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ConverterController extends Controller
{
    public function index()
    {
        return view('converter');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
        ]);

        $image = $request->file('image');
        $img = Image::make($image);
        
        // Convert to WebP
        $webpImage = $img->encode('webp', 80);
        
        // Generate filename
        $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $outputName = $filename . '.webp';
        
        // Return as download
        return response($webpImage)
            ->header('Content-Type', 'image/webp')
            ->header('Content-Disposition', 'attachment; filename="' . $outputName . '"');
    }
}