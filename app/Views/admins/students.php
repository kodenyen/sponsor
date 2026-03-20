<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-11 mx-auto">
        <?php flash('student_message'); ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Students</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="bi bi-plus-lg"></i> Add Student
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="py-3">Surname</th>
                                <th class="py-3">Class</th>
                                <th class="py-3">Email</th>
                                <th class="py-3 text-end px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['students'] as $student) : ?>
                                <tr>
                                    <td class="px-4"><?php echo $student->name; ?></td>
                                    <td><?php echo $student->surname; ?></td>
                                    <td><?php echo $student->class ? $student->class : '<span class="text-muted small">Not set</span>'; ?></td>
                                    <td><?php echo $student->email; ?></td>
                                    <td class="text-end px-4">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo URLROOT; ?>/admins/addStudent" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="John">
                </div>
                <div class="mb-3">
                    <label class="form-label">Surname</label>
                    <input type="text" name="surname" class="form-control" required placeholder="Doe">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Student</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
