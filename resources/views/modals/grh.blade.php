<!-- ========== GRH MODAL ========== -->
<div id="grhModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-lg-down" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%); border: none;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-folder-lock"></i> إدارة حضور العمال (GRH)
                </h5>
                <button class="btn-close btn-close-white" id="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-3 p-md-4">

                <!-- اختيار العامل -->
                <label class="fw-bold mb-2 d-block">اختر العامل:</label>
                <select id="grhPerson" class="form-select mb-4" style="min-height: 44px;">
                </select>

                <!-- التحقق -->
                <div class="mb-4">
                    <div class="row g-2 g-md-3">
                        <div class="col-auto">
                            <div class="form-check">
                                <input type="checkbox" id="checkedYes" class="form-check-input" style="width: 20px; height: 20px;">
                                <label class="form-check-label fw-bold ms-2"> تم التحقق</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input type="checkbox" id="checkedNo" class="form-check-input" style="width: 20px; height: 20px;">
                                <label class="form-check-label fw-bold ms-2"> لم يتم التحقق</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto ms-sm-auto">
                            <button id="verifyAllBtn" class="btn btn-outline-success btn-sm w-100 w-sm-auto" onclick="verifyAll()">
                                <i class="bi bi-check-all"></i> التحقق من الكل
                            </button>
                        </div>
                    </div>
                </div>

                <!-- الجداول -->
                <div class="row g-3">

                    <!-- جدول السحبات -->
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-danger text-white fw-bold rounded-top">
                                <i class="bi bi-cash-flow"></i> السحبات المالية
                            </div>

                            <div class="p-3 text-center fw-bold border-bottom">
                                مجموع السحبات: <span id="totalWithdraw" class="text-danger fs-5">0</span> دج
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;"></th>
                                            <th>التاريخ</th>
                                            <th>الوقت</th>
                                            <th>المبلغ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grhTransactions"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الورديات -->
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-success text-white fw-bold rounded-top">
                                <i class="bi bi-calendar-check"></i> الورديات (1600 دج لكل وردية)
                            </div>

                            <div class="p-3 text-center fw-bold border-bottom">
                                مجموع الورديات: <span id="totalShifts" class="text-success fs-5">0</span> دج
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;"></th>
                                            <th>التاريخ</th>
                                            <th>الوقت</th>
                                            <th>المبلغ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grhShifts"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- صافي الراتب -->
                <div class="card shadow-sm mt-4 border-0">
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-muted mb-2">صافي الراتب</h6>
                        <h3 class="text-primary fw-bold mb-0">
                            <span id="netSalary">0</span> دج
                        </h3>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
    @media (max-width: 992px) {
        #grhModal .modal-dialog {
            max-width: 95vw;
        }
    }

    @media (max-width: 576px) {
        #grhModal .table-responsive {
            font-size: 0.85rem;
        }

        #grhModal .form-select {
            font-size: 16px;
        }

        #grhModal .row.g-3 {
            gap: 1rem !important;
        }

        #grhModal .col-12 {
            min-width: 0;
        }
    }

    .modal-fullscreen-lg-down {
        @media (max-width: 992px) {
            max-width: 100% !important;
            margin: 0 !important;
            height: 100%;
        }
    }
</style>
