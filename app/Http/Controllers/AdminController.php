<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function messages()
    {
        $messages = Message::with(['sender', 'receiver'])->where('status', 'pending')->get();
        return view('admin.messages', compact('messages'));
    }

    public function approveMessage(Message $message)
    {
        $message->update(['status' => 'approved']);
        return back()->with('success', 'Message approved.');
    }

    public function rejectMessage(Message $message)
    {
        $message->update(['status' => 'rejected']);
        return back()->with('success', 'Message rejected.');
    }
}
