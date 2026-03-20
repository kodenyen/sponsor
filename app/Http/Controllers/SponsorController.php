<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SponsorToken;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    public function tokenAccess(Request $request)
    {
        $token = $request->query('token');
        
        if (!$token) {
            return redirect('/')->with('error', 'No token provided.');
        }

        $sponsorToken = SponsorToken::with('sponsor')->where('token', $token)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })->first();

        if ($sponsorToken && $sponsorToken->sponsor) {
            Auth::login($sponsorToken->sponsor);
            return redirect()->route('sponsor.dashboard');
        }

        return redirect('/')->with('error', 'Invalid or expired access link.');
    }

    public function dashboard()
    {
        $sponsor = Auth::user();
        $assignedStudents = $sponsor->assignedStudents;
        return view('sponsor.dashboard', compact('assignedStudents'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        \App\Models\Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->student_id,
            'content' => $request->content,
            'status' => 'pending',
            'type' => 'sponsor_to_student',
        ]);

        return back()->with('success', 'Message sent successfully. It is pending admin approval.');
    }
}
