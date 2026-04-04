<!-- Shift Settings Modal -->
<div class="modal fade" id="shiftSettingsModal" tabindex="-1" role="dialog" aria-labelledby="shiftSettingsTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-warning text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
                <h5 class="modal-title" id="shiftSettingsTitle">
                    <i class="bi bi-gear-fill"></i> إعدادات أوقات الورديات
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle"></i> حدد أوقات بداية ونهاية الوردية النهارية والليلية
                </p>

                <!-- Day Shift Settings -->
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="bi bi-sun-fill"></i> الوردية النهارية
                    </h6>
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">وقت البداية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="dayStartHour" class="form-control form-control-sm form-control-md" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="dayStartMin" class="form-control form-control-sm form-control-md" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">وقت النهاية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="dayEndHour" class="form-control form-control-sm form-control-md" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="dayEndMin" class="form-control form-control-sm form-control-md" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Night Shift Settings -->
                <div class="mb-4">
                    <h6 class="fw-bold text-info mb-3">
                        <i class="bi bi-moon-stars-fill"></i> الوردية الليلية
                    </h6>
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">وقت البداية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="nightStartHour" class="form-control form-control-sm form-control-md" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="nightStartMin" class="form-control form-control-sm form-control-md" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">وقت النهاية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="nightEndHour" class="form-control form-control-sm form-control-md" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="nightEndMin" class="form-control form-control-sm form-control-md" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 gap-2">
                <button type="button" class="btn btn-secondary w-100 w-sm-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> إلغاء
                </button>
                <button type="button" class="btn btn-warning text-white fw-semibold w-100 w-sm-auto" onclick="saveShiftSettings()">
                    <i class="bi bi-check-lg"></i> حفظ التغييرات
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control-sm {
        min-height: 36px;
    }

    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem !important;
        }

        .modal-body {
            padding: 1rem !important;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .modal-header h5 {
            font-size: 1.1rem;
        }

        .row.g-2 {
            gap: 0.5rem !important;
        }

        .col-12 {
            min-width: 0;
        }

        .d-flex.gap-2 {
            gap: 0.3rem !important;
        }

        .form-control {
            font-size: 16px;
        }

        .modal-footer .btn {
            margin: 0.25rem;
        }
    }

    @media (min-width: 577px) {
        .w-sm-auto {
            width: auto !important;
        }

        .form-control-md {
            min-height: 42px;
        }
    }

    @media (max-width: 768px) {
        .modal-lg {
            max-width: 95vw !important;
        }
    }
</style>
