@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <h2 class="mb-4">Admin Dashboard</h2>
            
            <div class="card">
                <div class="card-header">Quick Actions</div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.messages') }}" class="btn btn-primary btn-lg">Review Pending Messages</a>
                        <a href="#" class="btn btn-outline-secondary btn-lg">Manage Users</a>
                        <a href="#" class="btn btn-outline-secondary btn-lg">Form Builder</a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">System Overview</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Sponsors
                            <span class="badge bg-primary rounded-pill">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Students
                            <span class="badge bg-primary rounded-pill">0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
