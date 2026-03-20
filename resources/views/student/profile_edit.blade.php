@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <h2 class="mb-4">Edit My Profile</h2>

            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-header">Personal Information</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Surname</label>
                            <input type="text" name="surname" class="form-control" value="{{ $profile->surname }}">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control" value="{{ $profile->age }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Class</label>
                                <input type="text" name="class" class="form-control" value="{{ $profile->class }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">About Me</label>
                            <textarea name="about" rows="4" class="form-control">{{ $profile->about }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">Photos & Media</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                            @if($profile->profile_photo)
                                <small class="text-success">Current photo uploaded.</small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Banner Image</label>
                            <input type="file" name="banner_image" class="form-control" accept="image/*">
                            @if($profile->banner_image)
                                <small class="text-success">Current banner uploaded.</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Result Files (PDF)</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Upload New Files</label>
                            <input type="file" name="result_files[]" class="form-control" accept="application/pdf" multiple>
                        </div>
                        @if($profile->result_files)
                            <h6>Existing Files:</h6>
                            <ul class="list-group">
                                @foreach($profile->result_files as $file)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ basename($file) }}
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-outline-info">View</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2 mb-5">
                    <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
