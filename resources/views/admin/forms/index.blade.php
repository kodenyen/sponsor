@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Form Builder</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFormModal">Create New Form</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($forms as $form)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $form->title }}</span>
                        <span class="badge bg-info text-dark text-capitalize">{{ $form->target_role }}</span>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">{{ $form->description }}</p>
                        <h6>Fields:</h6>
                        <ul class="list-unstyled">
                            @foreach($form->fields as $field)
                                <li><i class="bi bi-dot"></i> {{ $field['label'] }} ({{ $field['type'] }})</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <form action="{{ route('admin.forms.destroy', $form->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Delete Form</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No dynamic forms created yet.</div>
            </div>
        @endforelse
    </div>

    <!-- Create Form Modal -->
    <div class="modal fade" id="createFormModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.forms.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create Dynamic Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Form Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g., Progress Report">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Target Audience</label>
                        <select name="target_role" class="form-select" required>
                            <option value="student">Students</option>
                            <option value="sponsor">Sponsors</option>
                        </select>
                    </div>
                    
                    <hr>
                    <h6>Form Fields</h6>
                    <div id="fields-container">
                        <div class="row g-2 mb-2 field-row">
                            <div class="col-7">
                                <input type="text" name="field_labels[]" class="form-control form-control-sm" placeholder="Field Label (e.g., Your Message)" required>
                            </div>
                            <div class="col-4">
                                <select name="field_types[]" class="form-select form-select-sm" required>
                                    <option value="text">Short Text</option>
                                    <option value="textarea">Long Text</option>
                                    <option value="dropdown">Dropdown (Coming soon)</option>
                                    <option value="file">File Upload</option>
                                </select>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-field" disabled>×</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="add-field">+ Add More Field</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Form</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-field').addEventListener('click', function() {
    const container = document.getElementById('fields-container');
    const firstRow = container.querySelector('.field-row');
    const newRow = firstRow.cloneNode(true);
    
    // Reset inputs
    newRow.querySelector('input').value = '';
    newRow.querySelector('select').selectedIndex = 0;
    
    // Enable remove button
    const removeBtn = newRow.querySelector('.remove-field');
    removeBtn.disabled = false;
    removeBtn.addEventListener('click', function() {
        newRow.remove();
    });
    
    container.appendChild(newRow);
});
</script>
@endsection
