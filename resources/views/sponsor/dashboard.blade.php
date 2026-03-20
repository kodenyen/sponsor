@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Sponsor Dashboard</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            Send a Message
        </div>
        <div class="card-body">
            <form action="{{ route('sponsor.messages.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="student_id" class="form-label">Select Assigned Student</label>
                    <select name="student_id" id="student_id" class="form-select" required>
                        <option value="">-- Choose a student --</option>
                        @foreach($assignedStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->studentProfile->surname ?? '' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Message Content</label>
                    <textarea name="content" id="content" rows="4" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 sticky-bottom-btn mt-3">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection
