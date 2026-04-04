<div id="shiftModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%); border: none;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-calendar-check"></i> اختيار الوردية
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 p-md-4">
            </div>

            <div class="modal-footer border-top-0 gap-2 p-3 p-md-4">
                <!-- زر الإلغاء -->
                <button class="btn btn-secondary w-100 w-sm-auto" id="closeModal" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> إلغاء
                </button>

                <!-- زر تسجيل الوردية -->
                <button class="btn btn-primary w-100 w-sm-auto fw-semibold" onclick="saveShift()">
                    <i class="bi bi-check-lg"></i> تسجيل الوردية
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .modal-body {
            padding: 1rem !important;
        }

        .modal-footer {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        .modal-footer .btn {
            width: 100%;
        }

        .form-control, .form-select {
            font-size: 16px;
            min-height: 44px;
        }

        .modal-title {
            font-size: 1.1rem;
        }
    }

    @media (min-width: 577px) {
        .w-sm-auto {
            width: auto !important;
        }
    }

    .modal-header {
        padding: 1rem 1.5rem;
    }
</style>
