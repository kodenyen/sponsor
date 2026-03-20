<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\StudentProfile;
use App\Models\User;
use App\Mail\NewMessagePending;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        $profile = $student->studentProfile;
        
        $messages = Message::where('receiver_id', $student->id)
            ->where('status', 'approved')
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('student.dashboard', compact('profile', 'messages'));
    }

    public function editProfile()
    {
        $student = Auth::user();
        $profile = $student->studentProfile;
        return view('student.profile_edit', compact('student', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::user();
        $profile = $student->studentProfile;

        $request->validate([
            'surname' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'class' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'result_files.*' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['surname', 'age', 'class', 'about']);

        if ($request->hasFile('profile_photo')) {
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        if ($request->hasFile('banner_image')) {
            if ($profile->banner_image) {
                Storage::disk('public')->delete($profile->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('banner_images', 'public');
        }

        if ($request->hasFile('result_files')) {
            $existingFiles = $profile->result_files ?? [];
            foreach ($request->file('result_files') as $file) {
                $existingFiles[] = $file->store('result_files', 'public');
            }
            $data['result_files'] = $existingFiles;
        }

        $profile->update($data);

        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully.');
    }

    public function replyMessage(Request $request)
    {
        $request->validate([
            'sponsor_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->sponsor_id,
            'content' => $request->content,
            'status' => 'pending',
            'type' => 'student_to_sponsor',
        ]);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NewMessagePending($message));
        }

        return back()->with('success', 'Reply sent successfully. It is pending admin approval.');
    }
}
