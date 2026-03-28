<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.feedback.index', compact('feedback'));
    }

    public function show(Feedback $feedback)
    {
        if (!$feedback->read) {
            $feedback->update(['read' => true]);
        }
        return view('admin.feedback.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully!');
    }
}