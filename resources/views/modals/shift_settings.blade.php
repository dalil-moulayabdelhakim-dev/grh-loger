<!-- Shift Settings Modal -->
<div class="modal fade" id="shiftSettingsModal" tabindex="-1" role="dialog" aria-labelledby="shiftSettingsTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
                <h5 class="modal-title" id="shiftSettingsTitle">
                    <i class="bi bi-gear-fill"></i> إعدادات أوقات الورديات
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle"></i> حدد أوقات بداية ونهاية الوردية النهارية والليلية
                </p>

                <!-- Day Shift Settings -->
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="bi bi-sun-fill"></i> الوردية النهارية
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">وقت البداية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="dayStartHour" class="form-control" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="dayStartMin" class="form-control" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">وقت النهاية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="dayEndHour" class="form-control" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="dayEndMin" class="form-control" min="0" max="59" placeholder="الدقيقة">
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">وقت البداية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="nightStartHour" class="form-control" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="nightStartMin" class="form-control" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">وقت النهاية</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="nightEndHour" class="form-control" min="0" max="23" placeholder="الساعة">
                                <span class="align-self-center">:</span>
                                <input type="number" id="nightEndMin" class="form-control" min="0" max="59" placeholder="الدقيقة">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> إلغاء
                </button>
                <button type="button" class="btn btn-warning text-white fw-semibold" onclick="saveShiftSettings()">
                    <i class="bi bi-check-lg"></i> حفظ التغييرات
                </button>
            </div>
        </div>
    </div>
</div>
