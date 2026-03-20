<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        $profile = $student->studentProfile;
        
        $messages = Message::where('receiver_id', $student->id)
            ->where('status', 'approved')
            ->with('sender')
            ->get();
            
        return view('student.dashboard', compact('profile', 'messages'));
    }

    public function replyMessage(Request $request)
    {
        $request->validate([
            'sponsor_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->sponsor_id,
            'content' => $request->content,
            'status' => 'pending',
            'type' => 'student_to_sponsor',
        ]);

        return back()->with('success', 'Reply sent successfully. It is pending admin approval.');
    }
}
