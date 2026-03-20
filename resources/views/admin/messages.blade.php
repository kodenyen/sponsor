@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pending Messages</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($messages as $message)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>From: {{ $message->sender->name }} | To: {{ $message->receiver->name }}</span>
                <span class="badge bg-warning text-dark">Pending</span>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $message->content }}</p>
                <div class="d-flex gap-2 mt-3">
                    <form action="{{ route('admin.messages.approve', $message->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Approve</button>
                    </form>
                    <form action="{{ route('admin.messages.reject', $message->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Reject</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No pending messages to review.</div>
    @endforelse
</div>
@endsection
