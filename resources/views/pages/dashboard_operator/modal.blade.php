<!-- Take Modal -->
<div class="modal fade" id="takeModal" tabindex="-1" role="dialog" aria-labelledby="takeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="takeModalTitle">
                    <i class="fe fe-check-circle"></i> Confirm Take Activity
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to take this activity?</p>
                <div class="" role="alert">
                    <strong>Activity Name: </strong> <span id="activityName"></span>
                </div>
                <div class="" role="alert">
                    <strong>Location: </strong> <span id="activityLocation"></span>
                </div>
                <p class="text-muted mb-0">
                    <i class="fe fe-info"></i> This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">
                    <i class="fe fe-x"></i> Cancel
                </button>
                <form id="takeForm" method="POST" style="display:inline-block;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn mb-2 btn-primary">
                        <i class="fe fe-check"></i> Yes, Take Activity
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
