<!-- Modal للتأكيد -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="confirmationModalLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    {{ __('Confirmation Required') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fa fa-question-circle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="confirmationMessage">
                    {{ __('Are you sure you want to perform this action?') }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i>
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-danger" id="confirmActionBtn">
                    <i class="fa fa-check me-1"></i>
                    {{ __('Confirm') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// متغيرات عامة للـ Modal
let confirmationCallback = null;
let confirmationForm = null;

// دالة لإظهار Modal التأكيد
function showConfirmationModal(message, callback, form = null) {
    document.getElementById('confirmationMessage').textContent = message;
    confirmationCallback = callback;
    confirmationForm = form;
    
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
}

// دالة لإظهار Modal التأكيد للنماذج
function showFormConfirmationModal(message, form) {
    showConfirmationModal(message, function() {
        if (form) {
            form.submit();
        }
    }, form);
}

// معالج النقر على زر التأكيد
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById('confirmActionBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (confirmationCallback) {
                confirmationCallback();
            }
            
            // إخفاء الـ Modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
            if (modal) {
                modal.hide();
            }
            
            // إعادة تعيين المتغيرات
            confirmationCallback = null;
            confirmationForm = null;
        });
    }
});
</script>