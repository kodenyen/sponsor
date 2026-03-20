@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-12 mb-4">
            <div class="card">
                @if($profile && $profile->banner_image)
                    <img src="{{ asset('storage/' . $profile->banner_image) }}" class="card-img-top" alt="Banner">
                @else
                    <div style="height: 100px; background-color: #005BFF; border-radius: 1rem 1rem 0 0;"></div>
                @endif
                <div class="card-body text-center">
                    @if($profile && $profile->profile_photo)
                        <img src="{{ asset('storage/' . $profile->profile_photo) }}" class="rounded-circle mb-3" width="100" height="100" alt="Profile" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center mb-3" style="width: 100px; height: 100px; font-size: 2rem;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <h4 class="card-title">{{ auth()->user()->name }} {{ $profile->surname ?? '' }}</h4>
                    <p class="card-text text-muted">{{ $profile->class ?? 'Class not set' }} | Age: {{ $profile->age ?? 'N/A' }}</p>
                    <a href="{{ route('student.profile.edit') }}" class="btn btn-sm btn-outline-primary">Edit Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header">Messages from Sponsors</div>
                <div class="card-body">
                    @forelse($messages as $message)
                        <div class="border-bottom pb-3 mb-3">
                            <strong>{{ $message->sender->name }}</strong> <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            <p class="mt-2">{{ $message->content }}</p>
                            
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#reply-{{ $message->id }}">Reply</button>
                            
                            <div class="collapse mt-3" id="reply-{{ $message->id }}">
                                <form action="{{ route('student.messages.reply') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sponsor_id" value="{{ $message->sender_id }}">
                                    <div class="mb-2">
                                        <textarea name="content" rows="2" class="form-control" required placeholder="Write your reply..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Send Reply</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No messages received yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
