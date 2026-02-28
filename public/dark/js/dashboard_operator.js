/**
 * Dashboard Operator - Activity Handler
 * Handles take activity & complete (return to IT Office) flow.
 */

document.addEventListener('DOMContentLoaded', function () {
    const config = window.DashboardOperatorConfig;
    if (!config) return;

    const TAKE_URL     = config.takeUrl;
    const COMPLETE_URL = config.completeUrl;
    const CSRF         = config.csrf;

    // Modal locked (cannot be closed by backdrop/keyboard)
    const activityModal = new bootstrap.Modal(document.getElementById('activityModal'), {
        backdrop: 'static',
        keyboard: false
    });

    // ── Take Activity ────────────────────────────────────────────────────────
    document.querySelectorAll('.btn-take').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const activityId = this.dataset.id;
            const location   = this.dataset.location;

            fetch(TAKE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify({ activity_id: activityId, location: location })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    activityModal.show();
                } else {
                    alert('Failed to take activity. Please try again.');
                }
            })
            .catch(() => alert('An error occurred. Please try again.'));
        });
    });

    // ── Complete Activity (Back to IT Office) ────────────────────────────────
    document.getElementById('btnCompleteActivity').addEventListener('click', function () {
        const btn = this;
        btn.disabled    = true;
        btn.textContent = 'Processing...';

        fetch(COMPLETE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                activityModal.hide();
                window.location.reload();
            } else {
                alert(data.message || 'Failed to complete activity.');
                btn.disabled    = false;
                btn.textContent = "Yes, I'm Back at IT Office";
            }
        })
        .catch(() => {
            alert('An error occurred. Please try again.');
            btn.disabled    = false;
            btn.textContent = "Yes, I'm Back at IT Office";
        });
    });
});
