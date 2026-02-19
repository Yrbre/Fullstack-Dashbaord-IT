<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalTitle">
                    <i class="fe fe-alert-triangle"></i> Confirm Delete
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this end user?</p>
                <div class="" role="alert">
                    <strong>End User Name: </strong> <span id="endUserName"></span><br>
                    <strong>Department: </strong> <span id="departmentName"></span>
                </div>
                <p class="text-muted mb-0">
                    <i class="fe fe-info"></i> This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">
                    <i class="fe fe-x"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" style="display:inline-block;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn mb-2 btn-danger">
                        <i class="fe fe-trash"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/enduser/delete.blade.php ENDPATH**/ ?>