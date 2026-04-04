<div id="addUserModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <div class="modal-header bg-success text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-person-plus"></i> بيانات المستخدم
                </h5>
                <button class="btn-close btn-close-white" id="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 p-md-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">نوع المستخدم</label>
                    <select name="user-type" id="selectUserType" class="form-select" style="display:none; min-height: 44px;">
                        <option value="manager">مدير</option>
                        <option value="worker">عامل</option>
                        <option value="customer">عميل</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">اسم المستخدم</label>
                    <input type="text" id="username" class="form-control" placeholder="ادخل اسم المستخدم" style="min-height: 44px;">
                </div>

                <div class="mb-3" style="display:none;">
                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                    <input type="email" id="useremail" class="form-control" placeholder="ادخل البريد الالكتروني" style="min-height: 44px;">
                </div>

                <div class="mb-3" style="display:none;">
                    <label class="form-label fw-semibold">كلمة المرور</label>
                    <input type="password" id="userpass" class="form-control" placeholder="ادخل كلمة المرور" style="min-height: 44px;">
                </div>

                <div class="mb-3" style="display:none;">
                    <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                    <input type="password" id="usercpass" class="form-control" placeholder="اعد ادخال كلمة المرور" style="min-height: 44px;">
                </div>

            </div>

            <div class="modal-footer border-top-0 gap-2 p-3 p-md-4">

                <!-- زر الإلغاء -->
                <button class="btn btn-secondary w-100 w-sm-auto" id="closeModal" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> إلغاء
                </button>

                <!-- زر إضافة المستخدم -->
                <button class="btn btn-success w-100 w-sm-auto fw-semibold" id="addUserBtn" onclick="addUser()">
                    <i class="bi bi-check-lg"></i> إضافة
                </button>

            </div>

        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        #addUserModal .form-control,
        #addUserModal .form-select {
            font-size: 16px;
        }

        #addUserModal .modal-footer {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        #addUserModal .modal-footer .btn {
            width: 100%;
        }
    }

    @media (min-width: 577px) {
        .w-sm-auto {
            width: auto !important;
        }
    }
</style>
