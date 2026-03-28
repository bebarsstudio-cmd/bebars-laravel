<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class YoutubeController extends Controller
{
    public function index()
    {
        return view('youtube.downloader');
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'quality' => 'in:best,highest,bestaudio'
        ]);

        $url = $request->url;
        $quality = $request->quality;

        // Using yt-dlp (you'll need to install yt-dlp on server)
        $command = [
            'yt-dlp',
            '-f', $quality == 'highest' ? 'best' : 'bestaudio/best',
            '-o', '-',
            $url
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            return back()->with('error', 'Download failed: ' . $process->getErrorOutput());
        }

        $videoContent = $process->getOutput();
        
        // Get video title
        $titleCommand = ['yt-dlp', '--get-title', $url];
        $titleProcess = new Process($titleCommand);
        $titleProcess->run();
        $title = trim($titleProcess->getOutput());
        
        // Clean filename
        $filename = preg_replace('/[^a-zA-Z0-9]/', '_', $title) . '.mp4';
        
        return response($videoContent)
            ->header('Content-Type', 'video/mp4')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}