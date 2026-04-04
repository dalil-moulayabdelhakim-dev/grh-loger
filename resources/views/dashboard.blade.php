<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.head')
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #0ea5e9;
            --accent-color: #06b6d4;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: clamp(1rem, 3vw, 1.5rem) 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: clamp(1rem, 3vw, 2rem);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: clamp(0.5rem, 2vw, 1rem);
        }

        .brand-section {
            flex: 1;
            min-width: 200px;
        }

        .brand-section h1 {
            margin: 0;
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            font-weight: 700;
            word-break: break-word;
        }

        .brand-section p {
            margin: 0;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            opacity: 0.9;
        }

        #userName {
            font-size: clamp(1rem, 2.5vw, 1.3rem);
            margin: 0;
            font-weight: 600;
            word-break: break-word;
        }

        #shiftCountdown {
            background: rgba(255, 255, 255, 0.2);
            padding: clamp(0.5rem, 2vw, 0.75rem) clamp(1rem, 3vw, 1.5rem);
            border-radius: 8px;
            backdrop-filter: blur(10px);
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 1rem);
            color: white;
            min-width: 200px;
            text-align: center;
        }

        .logoutBtn, .side-btn {
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            padding: clamp(0.5rem, 1.5vw, 0.6rem) clamp(1rem, 2vw, 1.5rem);
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logoutBtn {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .logoutBtn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: white;
        }

        .side-btn {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            gap: clamp(0.25rem, 1vw, 0.5rem);
            white-space: nowrap;
            width: auto;
        }

        .side-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .main-navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: clamp(1rem, 2vw, 1.5rem);
            border-bottom: 3px solid var(--secondary-color);
            position: sticky;
            top: 120px;
            z-index: 1020;
            width: 100%;
        }

        .main-navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 0;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .main-navbar li {
            border-right: 1px solid var(--border-color);
            flex: auto;
            min-width: auto;
        }

        .main-navbar li:last-child {
            border-right: none;
        }

        .main-navbar a {
            display: block;
            padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            font-size: clamp(0.75rem, 2vw, 0.95rem);
            text-align: center;
        }

        .main-navbar a:hover {
            background: var(--light-bg);
            color: var(--secondary-color);
            border-bottom-color: var(--secondary-color);
        }

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 clamp(0.75rem, 3vw, 1rem);
            width: 100%;
        }

        .card {
            border-radius: 16px !important;
            overflow: hidden;
        }

        .form-control, .form-select {
            min-height: 44px;
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        .btn {
            min-height: 44px;
            min-width: 44px;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            padding: clamp(0.5rem, 1.5vw, 0.75rem) clamp(1rem, 2vw, 1.25rem);
        }

        .table {
            font-size: clamp(0.75rem, 2vw, 0.95rem);
        }

        table th, table td {
            padding: clamp(0.5rem, 1.5vw, 0.75rem);
        }

        h1, h2, h3, h4, h5, h6 {
            word-break: break-word;
        }

        .d-flex {
            flex-wrap: wrap;
        }

        .gap-3 {
            gap: clamp(0.5rem, 2vw, 1rem) !important;
        }

        .gap-2 {
            gap: clamp(0.25rem, 1.5vw, 0.5rem) !important;
        }

        .modal-dialog {
            margin: clamp(0.5rem, 2vh, 1.75rem) auto !important;
        }

        .modal-content {
            border-radius: 12px !important;
        }

        .modal-body, .modal-header, .modal-footer {
            padding: clamp(1rem, 3vw, 1.5rem) !important;
        }

        .modal-title {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
        }

        /* Tablet and below */
        @media (max-width: 1024px) {
            .navbar-content {
                gap: 0.5rem;
            }

            .side-buttons {
                width: 100%;
                justify-content: flex-end;
            }

            .side-btn {
                flex: 0 1 auto;
            }

            #toggleNavBtn {
                display: none !important;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            html {
                font-size: 14px;
            }

            .navbar-header {
                padding: 1rem 0;
                margin-bottom: 1rem;
            }

            .navbar-content {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .brand-section {
                min-width: 100%;
            }

            .brand-section h1 {
                font-size: 1.3rem;
                margin-bottom: 0.25rem;
            }

            .brand-section p {
                font-size: 0.8rem;
            }

            #userName {
                font-size: 1rem;
                margin-top: 1rem;
            }

            #shiftCountdown {
                min-width: 100%;
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }

            #toggleNavBtn {
                display: none !important;
            }

            .d-flex {
                flex-direction: column;
            }

            .main-navbar {
                position: relative;
                top: auto;
                margin-bottom: 1rem;
            }

            .main-navbar ul {
                flex-direction: column;
                justify-content: flex-start;
            }

            .main-navbar li {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .main-navbar li:last-child {
                border-bottom: none;
            }

            .main-navbar a {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
                text-align: right;
            }

            .side-btn {
                width: 100%;
                justify-content: flex-start;
                padding: 0.75rem 1rem;
                margin: 0;
            }

            .logoutBtn {
                width: 100%;
                justify-content: flex-start;
                padding: 0.75rem 1rem;
            }

            .main-content {
                padding: 0.75rem;
            }

            .card {
                margin-bottom: 1rem !important;
                padding: 1rem !important;
            }

            .row {
                margin-left: -0.5rem !important;
                margin-right: -0.5rem !important;
            }

            .col-md-6, .col-lg-3 {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }

            .form-control, .form-select, .btn {
                width: 100%;
                min-height: 44px;
            }

            .table {
                font-size: 0.75rem;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            table thead {
                display: none;
            }

            table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 1rem;
            }

            table td {
                display: block;
                text-align: right;
                padding: 0.5rem 0 !important;
            }

            table td:before {
                content: attr(data-label);
                font-weight: bold;
                float: left;
            }

            .modal-body {
                padding: 1rem !important;
            }

            .modal-dialog {
                margin: 0.5rem auto !important;
            }

            .modal.fade .modal-dialog {
                transition: none;
            }

            /* Touch-friendly improvements */
            a, button {
                touch-action: manipulation;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="date"],
            input[type="time"],
            select,
            textarea {
                font-size: 16px;
            }
        }

        /* Small phones */
        @media (max-width: 480px) {
            html {
                font-size: 13px;
            }

            .brand-section h1 {
                font-size: 1.1rem;
            }

            .brand-section p {
                font-size: 0.7rem;
            }

            .form-label {
                font-size: 0.85rem;
            }

            .btn-sm {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }

            .text-center {
                padding: 0.5rem;
            }
        }

        /* Landscape mode */
        @media (max-height: 600px) and (orientation: landscape) {
            .navbar-header {
                padding: 0.5rem 0;
                margin-bottom: 0.5rem;
            }

            .brand-section h1 {
                font-size: 1.2rem;
            }

            .main-navbar {
                top: 80px;
            }
        }
    </style>
</head>

<body>

    <div id="progress-bar"></div>

    <!-- Header Section -->
    <div class="navbar-header">
        <div class="main-content">
            <div class="navbar-content">
                <div class="brand-section">
                    <h1><i class="bi bi-speedometer2"></i> نظام إدارة الورديات والمعاملات</h1>
                    <p>نظام متكامل لإدارة وردياتك ومعاملاتك المالية</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div id="shiftCountdown" style="display:none;"></div>
                    <button id="toggleNavBtn" class="side-btn text-white btn-primary" style="display: none;"
                        onclick="toggleNavBar()">
                        <i class="bi bi-list"></i>
                    </button>
                    <button id="openShiftModal" class="side-btn text-white btn-primary" style="display: none;"
                        onclick="openShiftModal()">
                        <i class="bi bi-plus-lg"></i> طلب وردية
                    </button>
                    <button id="openGRH" class="side-btn text-white btn-dark" style="display:none;"
                        onclick="openGRHmodal()">
                        <i class="bi bi-folder-lock"></i> GRH
                    </button>
                    <button id="openShiftSettings" class="side-btn text-white" style="display:none; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"
                        onclick="openShiftSettingsModal()">
                        <i class="bi bi-gear"></i> إعدادات الورديات
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" id="logoutBtn" class="logoutBtn">
                            <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav id="navBar" style="display: none" class="main-navbar">
        <ul>
            <li><a id="analysisSectionNavBtn" href="#analysisSection">📊 تحليل المصاريف</a></li>
            <li><a id="workerAnalysisSectionNavBtn" href="#workerAnalysisSection">👤 تحليل العامل</a></li>
            <li><a id="requestShiftSectionBtn" href="#requestShiftSection">📅 طلب وردية</a></li>
            <li><a id="transactionsSectionNavBtn" href="#transactionsSection">💳 المعاملات</a></li>
        </ul>
    </nav>

    <!-- التطبيق -->
    <div id="app" class="main-content">

        <div class="d-flex justify-content-end align-items-center mb-4 gap-3 flex-wrap">
            <h2 id="userName" class="m-0"> الموظف: </h2>
        </div>

        <!-- ================= قسم التحليل (خاص بالمدير فقط) ================= -->
        <div id="analysisSection" class="card shadow-lg p-4 mt-4 mb-4 border-0 rounded-3" style="display:none;">

            <div class="d-flex align-items-center gap-3 mb-4">
                <i class="bi bi-bar-chart-fill" style="font-size: 2rem; color: var(--primary-color);"></i>
                <h4 class="mb-0 fw-bold" style="color: var(--primary-color);"> تحليل المصاريف</h4>
            </div>

            <!-- فلاتر التاريخ -->
            <div class="bg-light p-3 rounded-2 mb-4">
                <div class="row g-3">

                    <!-- اختيار تاريخ معيّن -->
                    <div id="singleDateBox" class="col-12 col-md-6">
                        <label class="fw-semibold text-muted mb-2 d-block">📅 تاريخ معيّن:</label>
                        <input id="singleDate" type="date" class="form-control form-control-lg shadow-sm border-2" onchange="loadAnalysis()" />
                    </div>

                    <!-- من/إلى -->
                    <div id="rangeBox" class="d-none">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="fw-semibold text-muted mb-2 d-block">من:</label>
                                <input id="rangeFrom" type="date" class="form-control form-control-lg shadow-sm border-2" onchange="loadAnalysis()" />
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="fw-semibold text-muted mb-2 d-block">إلى:</label>
                                <input id="rangeTo" type="date" class="form-control form-control-lg shadow-sm border-2" onchange="loadAnalysis()" />
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox للتبديل -->
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="toggleRange" onchange="toggleDateMode()">
                            <label for="toggleRange" class="form-check-label fw-semibold">عرض المدى الزمني (من – إلى)</label>
                        </div>
                    </div>

                </div>
            </div>


            <h5 class="fw-bold mb-4" style="color: var(--primary-color);">📊 إجمالي المصاريف حسب النوع:</h5>

            <!-- الكاردات -->
            <div class="row mb-4 g-3">

                <!-- نقد -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden" style="transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted fw-semibold mb-2">💵 نقد</h6>
                                    <h4 id="sumCash" class="fw-bold mb-0" style="color: var(--primary-color);">0 DA</h4>
                                </div>
                                <div style="background: rgba(6, 182, 212, 0.1); padding: 0.75rem; border-radius: 0.5rem;">
                                    <i class="bi bi-cash-stack" style="font-size:1.5rem; color: var(--accent-color);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ثلاجة -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden" style="transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted fw-semibold mb-2">❄️ ثلاجة</h6>
                                    <h4 id="sumFridge" class="fw-bold mb-0" style="color: var(--primary-color);">0 DA</h4>
                                </div>
                                <div style="background: rgba(239, 68, 68, 0.1); padding: 0.75rem; border-radius: 0.5rem;">
                                    <i class="bi bi-snow2" style="font-size:1.5rem; color: #ef4444;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- راتب -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden" style="transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted fw-semibold mb-2">👨‍💼 راتب</h6>
                                    <h4 id="sumSalary" class="fw-bold mb-0" style="color: var(--primary-color);">0 DA</h4>
                                </div>
                                <div style="background: rgba(251, 191, 36, 0.1); padding: 0.75rem; border-radius: 0.5rem;">
                                    <i class="bi bi-person-badge-fill" style="font-size:1.5rem; color: #fbbf24;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <h5 class="fw-bold mb-4" style="color: var(--primary-color);">📈 البيانات العامة:</h5>

            <!-- الكاردات -->
            <div class="row g-3">
                <!-- عدد الموظفين -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted fw-semibold mb-2">👥 الموظفين</h6>
                                    <h4 id="totalWorkers" class="fw-bold mb-0" style="color: var(--secondary-color);">0</h4>
                                </div>
                                <div style="background: rgba(14, 165, 233, 0.1); padding: 0.75rem; border-radius: 0.5rem;">
                                    <i class="bi bi-people-fill" style="font-size:1.5rem; color: var(--secondary-color);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- عدد العملاء -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted fw-semibold mb-2">🎥 العملاء</h6>
                                    <h4 id="totalCustomers" class="fw-bold mb-0" style="color: var(--secondary-color);">0</h4>
                                </div>
                                <div style="background: rgba(107, 114, 128, 0.1); padding: 0.75rem; border-radius: 0.5rem;">
                                    <i class="bi bi-person-video2" style="font-size:1.5rem; color: #6b7280;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المجموع الكلي -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-white fw-semibold mb-2 opacity-75">💰 المجموع الكلي</h6>
                                    <h4 id="total" class="fw-bold mb-0 text-white">0 DA</h4>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.2); padding: 0.75rem; border-radius: 0.5rem;">
                                    <i class="bi bi-currency-dollar text-white" style="font-size:1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="workerAnalysisSection" class="mt-4 mb-4" style="display:none;">

            <!-- بطاقة تحليل العامل -->
            <div class="mt-4 mb-2">

                <div class="card shadow-lg border-0 rounded-3 p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i class="bi bi-person-fill" style="font-size: 2rem; color: var(--secondary-color);"></i>
                        <h5 class="fw-bold mb-0" style="color: var(--secondary-color);">تحليل العامل</h5>
                    </div>

                    <!-- اختيار العامل -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اختر عامل:</label>
                        <select id="workerAnalysisSelect" class="form-select form-select-lg shadow-sm border-2" onchange="loadWorkerStats()">
                            <option value="">ابحث واختر عامل...</option>
                        </select>
                    </div>
                </div>

                <!-- بطاقات الإحصائيات -->
                <div id="workerStatsCards" style="display:none;" class="mt-4">
                    <div class="row g-3">

                        <!-- أيام العمل -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                                <div class="card-body p-4 text-center">
                                    <i class="bi bi-calendar-range" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem; display: block;"></i>
                                    <h6 class="fw-bold text-muted mb-2">أيام العمل</h6>
                                    <h4 id="ws_days" class="fw-bold mb-0" style="color: var(--primary-color);">0</h4>
                                </div>
                            </div>
                        </div>

                        <!-- عدد التحويلات -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                                <div class="card-body p-4 text-center">
                                    <i class="bi bi-arrow-left-right" style="font-size: 2rem; color: var(--secondary-color); margin-bottom: 0.5rem; display: block;"></i>
                                    <h6 class="fw-bold text-muted mb-2">التحويلات</h6>
                                    <h4 id="ws_transactions" class="fw-bold mb-0" style="color: var(--secondary-color);">0</h4>
                                </div>
                            </div>
                        </div>

                        <!-- مجموع المصاريف -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                                <div class="card-body p-4 text-center">
                                    <i class="bi bi-receipt" style="font-size: 2rem; color: #ef4444; margin-bottom: 0.5rem; display: block;"></i>
                                    <h6 class="fw-bold text-muted mb-2">المصاريف</h6>
                                    <h4 id="ws_expenses" class="fw-bold mb-0" style="color: #ef4444;">0 DA</h4>
                                </div>
                            </div>
                        </div>

                        <!-- مجموع مبالغ الوردية -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <div class="card-body p-4 text-center">
                                    <i class="bi bi-clock-history text-white" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                                    <h6 class="fw-bold text-white mb-2 opacity-75">الوردية</h6>
                                    <h4 id="ws_shifts" class="fw-bold mb-0 text-white">0 DA</h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div>

        <div id="requestShiftSection" class="card shadow-lg border-0 rounded-3 p-4 mb-4" style="display:none;">
            <div class="mt-3 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <i class="bi bi-calendar-check" style="font-size: 2rem; color: var(--primary-color);"></i>
                    <h5 class="fw-bold mb-0" style="color: var(--primary-color);">طلب وردية</h5>
                </div>

                <div class="row gy-3">

                    <!-- اختيار العامل -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold">اختر عامل:</label>
                        <select id="requestShiftSelect" class="form-select form-select-lg shadow-sm border-2" onchange="loadWorkerStats()">
                            <option value="">ابحث واختر عامل...</option>
                        </select>
                    </div>

                    <!-- اختيار التاريخ -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold">📅 تاريخ:</label>
                        <input id="rsDate" type="date" class="form-control form-control-lg shadow-sm border-2" />
                    </div>

                    <!-- اختيار الوقت -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold">⏰ الوقت:</label>
                        <input id="rsTime" type="time" class="form-control form-control-lg shadow-sm border-2" />
                    </div>

                    <!-- زر الإضافة -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label" style="visibility: hidden;" >.</label>
                        <button class="btn btn-lg btn-primary w-100 fw-semibold shadow-sm" id="sendShiftRequestBtn" onclick="sendShiftRequest()">
                            <i class="bi bi-send"></i> ارسال الطلب
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <!-- إضافة معاملة -->
        <div id="transactionsSection" class="card shadow-lg border-0 rounded-3 p-4 mb-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <i class="bi bi-plus-circle-fill" style="font-size: 2rem; color: var(--primary-color);"></i>
                <h4 class="mb-0 fw-bold" style="color: var(--primary-color);">إضافة معاملة</h4>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <div class="row g-3 align-items-end">
                        <!-- للعامل: عرض اسمه فقط -->
                        <div id="personDisplay" class="col-12 col-sm-6 col-md-4" style="display:none;">
                            <label class="form-label fw-semibold">الموظف:</label>
                            <div class="form-control form-control-lg shadow-sm border-2 bg-light" style="padding: 0.5rem 0.75rem; display: flex; align-items: center;">
                                <span id="personDisplayName" style="color: var(--primary-color); font-weight: 600;"></span>
                            </div>
                        </div>

                        <!-- للمدير: قائمة منسدلة -->
                        <div id="personSelectContainer" class="col-12 col-sm-6 col-md-4">
                            <label class="form-label fw-semibold">الموظف:</label>
                            <select id="personSelect" class="form-select form-select-lg shadow-sm border-2">
                                <!-- الخيارات -->
                            </select>
                        </div>

                        <div class="col-12 col-sm-auto">
                            <button id="openAddUserModal" class="btn btn-outline-success btn-lg" type="button"
                                onclick="openAddUserModal()" title="إضافة موظف جديد">
                                <i class="bi bi-person-plus-fill"></i>
                            </button>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label fw-semibold">النوع:</label>
                            <select id="typeSelect" class="form-select form-select-lg shadow-sm border-2">
                                <option value="">اختر نوع</option>
                                <option value="نقد">💵 نقد</option>
                                <option value="ثلاجة">❄️ ثلاجة</option>
                                <option value="راتب">👨‍💼 راتب</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold">المبلغ (DA):</label>
                            <input id="amountInput" class="form-control form-control-lg shadow-sm border-2" placeholder="0.00" type="number" />
                        </div>

                        <div class="col-12 col-sm-6 col-md-auto">
                            <button class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm" id="addRecordBtn" onclick="addRecord()">
                                <i class="bi bi-plus"></i> إضافة
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- الجدول -->
        <div id="recordsTable" class="card shadow-lg border-0 rounded-3 p-4" style="display:none;">

            <!-- الفلتر -->
            <div id="recordFilter" class="bg-light p-4 mb-4 rounded-2" style="display:none;">
                <h5 class="mb-3 fw-bold text-muted">🔍 البحث والتصفية</h5>
                <div class="row g-3">

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">الموظف:</label>
                        <select id="searchName" class="form-select form-select-lg shadow-sm border-2">
                            <option value="">كل الاشخاص</option>
                            <!-- الخيارات سيتم ملؤها من JS -->
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">النوع:</label>
                        <select id="searchType" class="form-select form-select-lg shadow-sm border-2">
                            <option value="">كل الأنواع</option>
                            <option value="نقد">نقد</option>
                            <option value="ثلاجة">ثلاجة</option>
                            <option value="راتب">راتب</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">من:</label>
                        <input id="fromDate" class="form-control form-control-lg shadow-sm border-2" type="date" />
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">إلى:</label>
                        <input id="toDate" class="form-control form-control-lg shadow-sm border-2" type="date" />
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="m-0 fw-bold">📊 المعاملات</h4>
                <div class="text-end">
                    <h6 class="text-muted mb-0">المجموع:</h6>
                    <h4 id="totalAmount" class="m-0 fw-bold" style="color: var(--primary-color);">0 DA</h4>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

                <div class="d-flex gap-2 flex-wrap">
                    <button id="multiVerifyBtn" class="btn btn-outline-primary" onclick="verifySelectedRecords()"
                        style="display:none;">
                        <i class="bi bi-check-circle"></i> تحقق من المحدد
                    </button>

                    <button id="exportBtn" class="btn btn-outline-success" onclick="exportXLSX()"
                        style="display:none;">
                        <i class="bi bi-download"></i> استخراج Excel
                    </button>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
                        <tr class="text-white">
                            <th style="width: 50px;">
                                <input type="checkbox" id="selectAllCheckbox" style="display:none;">
                            </th>
                            <th style="width: 40px;"></th>
                            <th>الاسم</th>
                            <th class="text-center">المبلغ (DA)</th>
                            <th class="text-center">النوع</th>
                            <th class="text-center">التاريخ</th>
                            <th class="text-center">الوقت</th>
                            <th class="text-center" style="width: 100px;">إجراء</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTable">
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
                                لا توجد معاملات
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagintion" class="mt-4"></div>

            <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top flex-wrap">

                <button id="multiVerifyBtn" class="btn btn-outline-primary" onclick="verifySelectedRecords()"
                    style="display:none;">
                    <i class="bi bi-check-circle"></i> تحقق من المحدد
                </button>

                <button id="exportBtn" class="btn btn-outline-success" onclick="exportXLSX()" style="display:none;">
                    <i class="bi bi-download"></i> استخراج Excel
                </button>

            </div>
        </div>
    </div>


    @include('modals.shift')
    @include('modals.grh')
    @include('modals.add_user')
    @include('modals.shift_settings')




    @include('layout.scripts')
</body>

</html>
