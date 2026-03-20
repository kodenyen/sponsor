<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-10 mx-auto">
        <?php flash('message_success'); ?>
        <h2 class="mb-4">Pending Messages</h2>
        
        <?php if(empty($data['messages'])) : ?>
            <div class="card p-5 text-center shadow-sm border-0 rounded-4">
                <i class="bi bi-chat-left-dots display-1 text-muted mb-3"></i>
                <h4 class="text-muted">No pending messages to moderate.</h4>
            </div>
        <?php endif; ?>

        <?php foreach($data['messages'] as $message) : ?>
            <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-primary rounded-pill mb-1"><?php echo ucwords(str_replace('_', ' ', $message->type)); ?></span>
                        <div class="fw-bold">
                            <?php echo $message->sender_name; ?> 
                            <i class="bi bi-arrow-right text-muted mx-2"></i> 
                            <?php echo $message->receiver_name; ?>
                        </div>
                    </div>
                    <small class="text-muted"><?php echo date('M d, H:i', strtotime($message->created_at)); ?></small>
                </div>
                <div class="card-body py-4 bg-light bg-opacity-10">
                    <p class="card-text fs-5"><?php echo nl2br($message->content); ?></p>
                </div>
                <div class="card-footer bg-white py-3 border-top-0 d-flex gap-3">
                    <a href="<?php echo URLROOT; ?>/admins/approveMessage/<?php echo $message->id; ?>" class="btn btn-success flex-grow-1 py-2 rounded-3">
                        <i class="bi bi-check-lg"></i> Approve
                    </a>
                    <a href="<?php echo URLROOT; ?>/admins/rejectMessage/<?php echo $message->id; ?>" class="btn btn-danger flex-grow-1 py-2 rounded-3">
                        <i class="bi bi-x-lg"></i> Reject
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
