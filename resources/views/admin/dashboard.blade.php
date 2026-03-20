@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <h2 class="mb-4">Admin Dashboard</h2>
            
            <div class="card mb-4">
                <div class="card-header">System Overview</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <h3 class="mb-0">{{ $sponsorCount }}</h3>
                            <small class="text-muted">Sponsors</small>
                        </div>
                        <div class="col-4 border-end">
                            <h3 class="mb-0">{{ $studentCount }}</h3>
                            <small class="text-muted">Students</small>
                        </div>
                        <div class="col-4">
                            <h3 class="mb-0 text-primary">{{ $pendingMessagesCount }}</h3>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Management Actions</div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.messages') }}" class="btn btn-primary btn-lg position-relative">
                            Review Pending Messages
                            @if($pendingMessagesCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $pendingMessagesCount }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline-primary btn-lg">Manage Sponsors & Tokens</a>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-primary btn-lg">Manage Students</a>
                        <a href="{{ route('admin.forms.index') }}" class="btn btn-outline-primary btn-lg">Form Builder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
