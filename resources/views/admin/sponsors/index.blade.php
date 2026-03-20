@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Sponsors</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSponsorModal">Add Sponsor</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($sponsors as $sponsor)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>{{ $sponsor->name }} ({{ $sponsor->email }})</span>
                <div>
                    <form action="{{ route('admin.sponsors.token', $sponsor->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">Generate Access Link</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @php
                    $sponsorToken = \App\Models\SponsorToken::where('sponsor_id', $sponsor->id)->first();
                @endphp

                @if($sponsorToken)
                    <div class="mb-3">
                        <label class="form-label small text-muted">Secure Access Link:</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" readonly value="{{ route('sponsor.access', ['token' => $sponsorToken->token]) }}" id="token-{{ $sponsor->id }}">
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('token-{{ $sponsor->id }}')">Copy</button>
                        </div>
                    </div>
                @endif

                <h6>Assigned Students:</h6>
                <ul class="list-group mb-3">
                    @forelse($sponsor->assignedStudents as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $student->name }}
                            <form action="{{ route('admin.assignments.destroy', [$sponsor->id, $student->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger border-0">Remove</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No students assigned.</li>
                    @endforelse
                </ul>

                <form action="{{ route('admin.assignments.store') }}" method="POST" class="row g-2">
                    @csrf
                    <input type="hidden" name="sponsor_id" value="{{ $sponsor->id }}">
                    <div class="col-8">
                        <select name="student_id" class="form-select form-select-sm" required>
                            <option value="">-- Assign a Student --</option>
                            @foreach($allStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-sm btn-success w-100">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Add Sponsor Modal -->
    <div class="modal fade" id="addSponsorModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.sponsors.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Sponsor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Initial Password</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Sponsor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard(id) {
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Link copied: " + copyText.value);
}
</script>
@endsection
