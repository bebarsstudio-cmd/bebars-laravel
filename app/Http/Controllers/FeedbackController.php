<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    /**
     * Store feedback from users.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:bug,feature,improvement,general',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to database
        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'subject' => $request->subject,
            'message' => $request->message,
            'page_url' => $request->page_url ?? null,
        ]);

        // Optional: Send email notification
        // Mail::to('bebarsstudio@gmail.com')->send(new FeedbackMail($request->all()));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your feedback!'
            ]);
        }

        return back()->with('success', 'Thank you for your feedback!');
    }
}