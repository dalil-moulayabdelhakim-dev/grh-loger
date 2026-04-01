<!-- ========== GRH MODAL ========== -->
    <div id="grhModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"> إدارة حضور العمال (GRH)</h5>
                    <button class="btn-close btn-close-white" id="closeModal" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- اختيار العامل -->
                    <label class="fw-bold mb-2">اختر العامل:</label>
                    <select id="grhPerson" class="form-select mb-3">
                    </select>

                    <!-- التحقق -->
                    <div class="d-flex gap-4 mb-4">
                        <div class="form-check">
                            <input type="checkbox" id="checkedYes" class="form-check-input">
                            <label class="form-check-label fw-bold"> تم التحقق</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="checkedNo" class="form-check-input">
                            <label class="form-check-label fw-bold"> لم يتم التحقق</label>
                        </div>

                        <!-- زر التحقق الكلي -->
                        <button id="verifyAllBtn" class="btn btn-outline-success btn-sm ms-4" onclick="verifyAll()">
                             التحقق من الكل
                        </button>
                    </div>


                    <!-- الجداول جنب بعض -->
                    <div class="row">

                        <!-- جدول السحبات -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-danger text-white fw-bold">
                                     السحبات المالية
                                </div>

                                <div class="p-2 text-center fw-bold">
                                    مجموع السحبات: <span id="totalWithdraw" class="text-danger fs-5">0</span> دج
                                </div>

                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th></th>
                                            <th>التاريخ</th>
                                            <th>الوقت</th>
                                            <th>المبلغ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grhTransactions"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- جدول الورديات -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white fw-bold">
                                     الورديات (1600 دج لكل وردية)
                                </div>

                                <div class="p-2 text-center fw-bold">
                                    مجموع الورديات: <span id="totalShifts" class="text-success fs-5">0</span> دج
                                </div>

                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th></th>
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

                    <!-- صافي الراتب -->
                    <div class="card shadow mt-3">
                        <div class="card-body text-center fs-4 fw-bold">
                             صافي الراتب:
                            <span id="netSalary" class="text-primary">0</span> دج
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
