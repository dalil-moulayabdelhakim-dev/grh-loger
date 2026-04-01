    <div id="addUserModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">بيانات المستخدم</h5>
                    <button class="btn-close" id="closeModal" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <select name="user-type" id="selectUserType" class="form-control mb-2" style="display:none;" >
                        <option value="manager">مدير</option>
                        <option value="worker">عامل</option>
                        <option value="customer">عميل</option>
                    </select>

                    <input type="text" id="username" class="form-control mb-2" placeholder="ادخل اسم الاسم">

                    <input type="text" id="useremail" class="form-control mb-2" style="display:none;"  placeholder="ادخل البريد الالكتروني">

                    <input type="text" id="userpass" class="form-control mb-2" style="display:none;"  placeholder="ادخل كلمة المرور">

                    <input type="text" id="usercpass" class="form-control mb-2" style="display:none;"  placeholder="اعد ادخال كلمة المرور">

                </div>

                <div class="modal-footer">

                    <!-- زر الإلغاء -->
                    <button class="btn btn-secondary" id="closeModal" data-bs-dismiss="modal">
                        إلغاء
                    </button>

                    <!-- زر تسجيل الوردية -->
                    <button class="btn btn-primary" id="addUserBtn" onclick="addUser()">
                        اضافة
                    </button>

                </div>

            </div>
        </div>
    </div>
