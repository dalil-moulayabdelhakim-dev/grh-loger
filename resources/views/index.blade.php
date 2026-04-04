<?php $env = require __DIR__ . '/env.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.head')
</head>

<body class="container py-4">

    <!-- التطبيق -->
    <div id="app">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>إدارة المعاملات</h2>
            <button id="openGRH" class="btn btn-dark" style="display:none;" onclick="openGRHmodal()">
                GRH
            </button>
            <button id="openShiftModal" class="btn btn-outline-primary mt-3" style="display: none;"
                onclick="openShiftModal()">
                تسجيل الوردية
            </button>

            <div id="shiftCountdown" style="display:none; font-weight:bold; margin-top:10px;"></div>

            <button class="btn btn-outline-danger" id="logoutBtn" onclick="logout()">تسجيل الخروج <i
                    class="bi bi-box-arrow-right"></i></button>
        </div>

        <!-- ================= قسم التحليل (خاص بالمدير فقط) ================= -->
        <div id="analysisSection" class="card shadow p-4 mt-4 mb-4" style="display:none;">

            <h4 class="mb-3 fw-bold"> تحليل المصاريف</h4>

            <!-- فلاتر التاريخ -->
            <div class="d-flex flex-wrap align-items-center gap-3 mb-4">

                <!-- اختيار تاريخ معيّن -->
                <div id="singleDateBox">
                    <label class="fw-semibold">تاريخ معيّن:</label>
                    <input id="singleDate" type="date" class="form-control shadow-sm" onchange="loadAnalysis()" />
                </div>

                <!-- من/إلى -->
                <div id="rangeBox" class="range-container flex-wrap align-items-center gap-3" style="display:none;">
                    <div>
                        <label class="fw-semibold">من:</label>
                        <input id="rangeFrom" type="date" class="form-control shadow-sm" onchange="loadAnalysis()" />
                    </div>

                    <div>
                        <label class="fw-semibold">إلى:</label>
                        <input id="rangeTo" type="date" class="form-control shadow-sm" onchange="loadAnalysis()" />
                    </div>
                </div>

                <!-- Checkbox للتبديل -->
                <div class="d-flex align-items-center gap-2 mt-4">
                    <input type="checkbox" id="toggleRange" onchange="toggleDateMode()">
                    <label for="toggleRange" class="fw-semibold">عرض المدى الزمني (من – إلى)</label>
                </div>

            </div>


            <h5 class="fw-bold mb-3">إجمالي المصاريف حسب النوع:</h5>

            <!-- الكاردات -->
            <div class="row g-3">

                <!-- نقد -->
                <div class="col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> نقد</h6>
                                <h4 id="sumCash" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-cash-stack text-primary" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>

                <!-- ثلاجة -->
                <div class="col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> ثلاجة</h6>
                                <h4 id="sumFridge" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-snow2 text-primary" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>

                <!-- راتب -->
                <div class="col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> راتب</h6>
                                <h4 id="sumSalary" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-person-badge-fill text-primary" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <!-- إضافة معاملة -->
        <div class="card shadow p-4 mb-4">
            <h4 class="mb-3">إضافة معاملة</h4>

            <div class="row g-3">
                <div class="col-md-10">
                    <div class="d-flex align-items-center gap-2">
                        <select id="personSelect" class="form-select">
                            <option value="">اختر الشخص...</option>
                            <!-- الخيارات -->
                        </select>

                        <!-- زر الإضافة -->
                        <button id="add-person-btn" class="btn btn-outline-success" type="button"
                            onclick="addPerson()">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>

                        <select id="typeSelect" class="form-select" style="width:150px;">
                            <option value="نقد">نقد</option>
                            <option value="ثلاجة">ثلاجة</option>
                            <option value="راتب">راتب</option>
                        </select>

                        <input id="amountInput" class="form-control" placeholder="المبلغ (DA)" type="number"
                            style="width:150px;" />
                    </div>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100" id="addRecordBtn" onclick="addRecord()">إضافة</button>
                </div>
            </div>

        </div>


        <!-- الجدول -->
        <div class="card shadow p-4">

            <!-- الفلتر -->
            <div class="p-1 mb-4">
                <h4 class="mb-3">البحث</h4>
                <div class="d-flex align-items-center gap-2 flex-wrap">

                    <div class="flex-grow-1">
                        <select id="searchName" class="form-select">
                            <option value="">كل الاشخاص</option>
                            <!-- الخيارات سيتم ملؤها من JS -->
                        </select>
                    </div>

                    <div class="text-center px-2 separator">
                        - أو -
                    </div>

                    <div class="flex-grow-1">
                        <select id="searchType" class="form-select">
                            <option value="">كل الأنواع</option>
                            <option value="نقد">نقد</option>
                            <option value="ثلاجة">ثلاجة</option>
                            <option value="راتب">راتب</option>
                        </select>
                    </div>

                    <div class="text-center px-2 separator">
                        - أو -
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <label>من:</label>
                        <input id="fromDate" class="form-control" type="date" />
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <label>إلى:</label>
                        <input id="toDate" class="form-control" type="date" />
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="m-0">المعاملات</h4>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2 p-2 gap-2">

                <div>
                    <button id="multiVerifyBtn" class="btn btn-outline-primary" onclick="verifySelectedRecords()"
                        style="display:none;">
                        تحقق من المحدد
                    </button>

                    <!-- <button id="multiDeleteBtn" class="btn btn-danger" onclick="deleteSelectedRecords()"
                    style="display:none;">
                    حذف المحدد
                </button> -->

                    <button id="exportBtn" class="btn btn-outline-success" onclick="exportXLSX()"
                        style="display:none;">
                        استخراج .xslx
                    </button>
                </div>

                <div class="d-flex justify-content-start ">
                    <h5>المجموع: <span id="totalAmount">0</span> DA</h5>
                </div>

            </div>




            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAllCheckbox" style="display:none;">
                            </th>
                            <th></th>
                            <th>الاسم</th>
                            <th>المبلغ (DA)</th>
                            <th>النوع</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTable"></tbody>
                </table>
            </div>

            <!-- Pagination Container -->
            <div id="pagintion" class="mt-4"></div>

            <div class="d-flex justify-content-end align-items-center mb-2 p-2 gap-2">

                <button id="multiVerifyBtn" class="btn btn-outline-primary" onclick="verifySelectedRecords()"
                    style="display:none;">
                    تحقق من المحدد
                </button>

                <!-- <button id="multiDeleteBtn" class="btn btn-danger" onclick="deleteSelectedRecords()"
                    style="display:none;">
                    حذف المحدد
                </button> -->

                <button id="exportBtn" class="btn btn-outline-success" onclick="exportXLSX()" style="display:none;">
                    استخراج .xslx
                </button>

            </div>
        </div>
    </div>

    @include('modals.shift')
    @include('modals.grh')




    @include('layout.scripts')
</body>

</html>
