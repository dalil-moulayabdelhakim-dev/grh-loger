<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.head')
</head>

<body class="container py-4">

    <div id="progress-bar"></div>

    <nav id="navBar" style="display: none" class="main-navbar">
        <ul>
            <li><a id="analysisSectionNavBtn" href="#analysisSection">تحليل المصاريف</a></li>
            <li><a id="workerAnalysisSectionNavBtn" href="#workerAnalysisSection">تحليل العامل</a></li>
            <li><a id="requestShiftSectionBtn" href="#requestShiftSection">طلب وردية</a></li>
            <li><a id="transactionsSectionNavBtn" href="#transactionsSection">المعاملات</a></li>
        </ul>
    </nav>

    <!-- التطبيق -->
    <div id="app">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
            <h2 id="userName"> الموظف: </h2>

            <div id="shiftCountdown" style="display:none; font-weight:bold; margin-top:10px;"></div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" id="logoutBtn" class="btn btn-outline-danger">تسجيل الخروج
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>

        </div>

        <div class="relative-box">

            <!-- الأزرار الجانبية -->
            <div class="side-buttons  pt-4">

                <button id="openGRH" class="side-btn text-white btn-dark" style="display:none;"
                    onclick="openGRHmodal()">
                    GRH
                </button>
                <button id="openShiftModal" class="side-btn text-white btn-primary  mt-3" style="display: none;"
                    onclick="openShiftModal() ">
                    SHF
                </button>
            </div>

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
            <div class="row mb-3  g-3">

                <!-- نقد -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> نقد</h6>
                                <h4 id="sumCash" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-cash-stack text-info" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>

                <!-- ثلاجة -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> ثلاجة</h6>
                                <h4 id="sumFridge" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-snow2 text-danger" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>

                <!-- راتب -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> راتب</h6>
                                <h4 id="sumSalary" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-person-badge-fill text-warning" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>
            </div>

<hr>

            <h5 class="fw-bold mb-3">البيانات العامة:</h5>

            <!-- الكاردات -->
            <div class="row g-3">
                <!-- راتب -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> عدد الموظفين</h6>
                                <h4 id="totalWorkers" class="mt-2 fw-bold">0</h4>
                            </div>
                            <i class="bi bi-people-fill text-primary" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>


                <!-- راتب -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> عدد العملاء</h6>
                                <h4 id="totalCustomers" class="mt-2 fw-bold">0</h4>
                            </div>
                            <i class="bi bi-person-video2 .text-secondary" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>

                <!-- راتب -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="p-3 rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 fw-bold"> المجموع الكلي</h6>
                                <h4 id="total" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                            <i class="bi bi-currency-dollar text-success" style="font-size:40px; opacity:0.7;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="workerAnalysisSection" class=" mt-4 mb-4" style="display:none;">

            <!-- بطاقة تحليل العامل -->
            <div class="mt-4 mb-2">

                <div class="card shadow">
                    <h5 class="fw-bold mb-2">تحليل العامل</h5>

                    <!-- اختيار العامل -->
                    <div class="mb-2">
                        <select id="workerAnalysisSelect" class="form-select" onchange="loadWorkerStats()">
                            <option value="">اختر عامل...</option>
                        </select>
                    </div>
                </div>

                <!-- بطاقات الإحصائيات -->
                <div id="workerStatsCards" style="display:none;">
                    <div class="row g-3">

                        <!-- أيام العمل -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card p-3 shadow text-center">
                                <h6 class="fw-bold m-0">أيام العمل</h6>
                                <h4 id="ws_days" class="mt-2 fw-bold">0</h4>
                            </div>
                        </div>

                        <!-- عدد التحويلات -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card shadow p-3 text-center">
                                <h6 class="fw-bold m-0">عدد التحويلات</h6>
                                <h4 id="ws_transactions" class="mt-2 fw-bold">0</h4>
                            </div>
                        </div>

                        <!-- مجموع المصاريف -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card p-3 shadow text-center">
                                <h6 class="fw-bold m-0">مجموع المصاريف</h6>
                                <h4 id="ws_expenses" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                        </div>

                        <!-- مجموع مبالغ الوردية -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card p-3 shadow text-center">
                                <h6 class="fw-bold m-0">مجموع الوردية</h6>
                                <h4 id="ws_shifts" class="mt-2 fw-bold">0 DA</h4>
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div>

        <div id="requestShiftSection" class="card shadow p-4 mb-4" style="display:none;">
            <div class="mt-4 mb-4">
                <h5 class="fw-bold mb-3">طلب وردية</h5>

                <div class="row gy-4">

                    <!-- اختيار العامل -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <select id="requestShiftSelect" class="form-select" onchange="loadWorkerStats()">
                            <option value="">اختر عامل...</option>
                        </select>
                    </div>

                    <!-- اختيار التاريخ -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="d-flex gap-3 align-items-center">
                            <label class="fw-semibold">تاريخ:</label>
                            <input id="rsDate" type="date" class="form-control shadow-sm" />
                        </div>
                    </div>

                    <!-- اختيار الوقت -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="d-flex gap-3 align-items-center">
                            <label class="fw-semibold">الوقت:</label>
                            <input id="rsTime" type="time" class="form-control shadow-sm" />
                        </div>
                    </div>

                    <!-- زر الإضافة -->
                    <div class="col-12 col-sm-6 col-md-2">
                        <button class="btn btn-primary w-100" id="sendShiftRequestBtn" onclick="sendShiftRequest()">ارسال الطلب</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- إضافة معاملة -->
        <div id="transactionsSection" class="card shadow p-4 mb-4">
            <h4 class="mb-3">إضافة معاملة</h4>

            <div class="row g-3">
                <div class="col-md-10">
                    <div class="d-flex align-items-center gap-2">
                        <select id="personSelect" class="form-select">

                            <!-- الخيارات -->
                        </select>

                        <!-- زر الإضافة -->
                        <button id="openAddUserModal" class="btn btn-outline-success" type="button"
                            onclick="openAddUserModal()">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>

                        <select id="typeSelect" class="form-select" style="width:150px;">
                            <option value="">اختر نوع</option>
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
            <div id="recordFilter" class="p-1 mb-4" style="display:none;">
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
                    <tbody id="recordsTable">
                        <tr>
                            <td colspan="8" class="text-center text-muted">لا توجد بيانات</td>
                        </tr>
                    </tbody>
                </table>
                <div id="pagintion"></div>
            </div>

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
    @include('modals.add_user')




    @include('layout.scripts')
</body>

</html>
