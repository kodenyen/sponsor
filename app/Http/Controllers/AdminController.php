<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\SponsorToken;
use App\Models\StudentProfile;
use App\Models\SponsorStudentAssignment;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $sponsorCount = User::where('role', 'sponsor')->count();
        $studentCount = User::where('role', 'student')->count();
        $pendingMessagesCount = Message::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact('sponsorCount', 'studentCount', 'pendingMessagesCount'));
    }

    // Sponsor Management
    public function sponsors()
    {
        $sponsors = User::where('role', 'sponsor')->with('assignedStudents')->get();
        $allStudents = User::where('role', 'student')->get();
        return view('admin.sponsors.index', compact('sponsors', 'allStudents'));
    }

    public function storeSponsor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'sponsor',
        ]);

        return back()->with('success', 'Sponsor created successfully.');
    }

    public function generateToken(User $user)
    {
        $token = Str::random(32);
        SponsorToken::updateOrCreate(
            ['sponsor_id' => $user->id],
            ['token' => $token, 'expires_at' => null]
        );

        return back()->with('success', 'Access link generated.');
    }

    // Student Management
    public function students()
    {
        $students = User::where('role', 'student')->with('studentProfile')->get();
        return view('admin.students.index', compact('students'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'surname' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'surname' => $request->surname,
        ]);

        return back()->with('success', 'Student created successfully.');
    }

    // Assignments
    public function assignStudent(Request $request)
    {
        $request->validate([
            'sponsor_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        SponsorStudentAssignment::firstOrCreate([
            'sponsor_id' => $request->sponsor_id,
            'student_id' => $request->student_id,
        ]);

        return back()->with('success', 'Student assigned to sponsor.');
    }

    public function removeAssignment($sponsorId, $studentId)
    {
        SponsorStudentAssignment::where('sponsor_id', $sponsorId)
            ->where('student_id', $studentId)
            ->delete();

        return back()->with('success', 'Assignment removed.');
    }

    // Message Management
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
