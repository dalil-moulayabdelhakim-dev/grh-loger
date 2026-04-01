document.addEventListener("DOMContentLoaded", function () {
    startSession();

    const yes = document.getElementById("checkedYes");
    const no = document.getElementById("checkedNo");

    yes.addEventListener("change", () => {
        if (yes.checked) no.checked = false;
        applyFilter();
    });

    no.addEventListener("change", () => {
        if (no.checked) yes.checked = false;
        applyFilter();
    });

    console.log(APP_ENV);

    // يظهر فقط إذا نحن في وضع التطوير
    if (typeof APP_ENV !== "undefined" && APP_ENV === "local") {
        const btn = document.createElement("button");
        btn.textContent = "حذف LocalStorage (Dev Only)";
        btn.id = "clearLocalStorageBtn";
        btn.style.position = "fixed";
        btn.style.bottom = "10px";
        btn.style.left = "10px";
        btn.style.zIndex = "9999";
        btn.style.padding = "10px 15px";
        btn.style.background = "#d9534f";
        btn.style.color = "#fff";
        btn.style.border = "none";
        btn.style.borderRadius = "6px";
        btn.style.cursor = "pointer";
        btn.style.fontSize = "14px";

        btn.onclick = () => {
            localStorage.removeItem("lastShiftTime");
            alert("تم حذف LocalStorage الخاص بالوردية (تطوير فقط)");
            checkShiftButton();
        };

        document.body.appendChild(btn);
    }

    document.querySelectorAll(".main-navbar a").forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute("href"));
            const yOffset = -70; // ارتفاع النافبار

            const y =
                target.getBoundingClientRect().top +
                window.pageYOffset +
                yOffset;

            window.scrollTo({ top: y, behavior: "smooth" });
        });
    });

    finishProgress();

    // Initialize button deactivation system
    initializeButtonDeactivation();
});

let role = null;
let id = null;

function startSession() {
    fetch("/session-info")
        .then((r) => r.json())
        .then((res) => {
            if (res.logged) {
                const user = res.user;

                role = user.role; // يجلب الدور من قاعدة البيانات

                id = user.id;
                const name = user.name;
                document.getElementById("userName").textContent =
                    `الموظف: ${name}`;
                // إخفاء صفحة الدخول وإظهار التطبيق
                document.getElementById("app").style.display = "block";

                // إذا كان المدير
                if (role === "manager") {
                    document.getElementById(
                        "workerAnalysisSection",
                    ).style.display = "block";
                    document.getElementById("analysisSection").style.display =
                        "block";
                    document.getElementById("exportBtn").style.display =
                        "inline-block";
                    document.getElementById("recordFilter").style.display =
                        "inline-block";
                    document.getElementById("openGRH").style.display =
                        "inline-block";
                    document.getElementById("navBar").style.display = "none";
                    document.getElementById("toggleNavBtn").style.display =
                        "inline-block";
                    document.getElementById(
                        "requestShiftSection",
                    ).style.display = "block";

                    document
                        .getElementById("selectAllCheckbox")
                        .addEventListener("change", function () {
                            const checked = this.checked;
                            document
                                .querySelectorAll(".record-checkbox")
                                .forEach((cb) => {
                                    cb.checked = checked;
                                });
                        });

                    loadAnalysis();
                    loadWorkersForAnalysis();
                } else {
                    // العامل
                    document.getElementById("openShiftModal").style.display =
                        "inline-block";
                }

                loadPeople();
                loadRecords();
                checkShiftButton();
            } else {
                // المستخدم غير مسجل دخول
                document.getElementById("login").style.display = "block";
                document.getElementById("app").style.display = "none";
            }
            finishProgress();
        })
        .catch((error) => console.log(error));
}

function checkShiftButton() {
    const btn = document.getElementById("openShiftModal");
    const countdownDiv = document.getElementById("shiftCountdown");

    if (role === "manager") {
        // console.log("الدور: مدير → لا يظهر شيء");
        if (btn) btn.style.display = "none";
        if (countdownDiv) countdownDiv.style.display = "none";
        return;
    }

    const lastShiftStr = localStorage.getItem("lastShiftTime");

    if (!lastShiftStr) {
        //console.log("أول تسجيل → الزر يظهر مباشرة");
        if (btn) btn.style.display = "block";
        if (countdownDiv) countdownDiv.style.display = "none";
        return;
    }

    const lastShift = new Date(lastShiftStr);
    const now = new Date();
    let nextAllowed;

    // console.log("آخر تسجيل:", lastShift.toLocaleString());
    // console.log("الوقت الحالي:", now.toLocaleString());

    // =========================
    // تحديد وقت الوردية التالية
    // =========================

    // إنشاء اليوم 07:30 و 19:30 بالنسبة لليوم الحالي
    const today0730 = new Date(now);
    today0730.setHours(7, 30, 0, 0);

    const today1930 = new Date(now);
    today1930.setHours(19, 30, 0, 0);

    const lastHour = lastShift.getHours();
    const nowHour = now.getHours();
    const lastMinute = lastShift.getMinutes();

    // 🟢 وردية نهارية (07:30 → 19:30)
    if (lastShift >= today0730 && lastShift < today1930) {
        nextAllowed = new Date(today1930);
        // console.log(
        //     "آخر وردية نهارية → nextAllowed:",
        //     nextAllowed.toLocaleString()
        // );
    }
    // 🔵 وردية مسائية قبل منتصف الليل (19:30 → 23:59)
    else if (lastHour >= 19 && nowHour >= 19) {
        const tomorrow0730 = new Date(today0730);
        tomorrow0730.setDate(tomorrow0730.getDate() + 1);
        nextAllowed = tomorrow0730;
        // console.log(
        //     "آخر وردية مسائية قبل منتصف الليل → nextAllowed:",
        //     nextAllowed.toLocaleString()
        // );
    }
    // 🌙 وردية مسائية بعد منتصف الليل (00:00 → 07:30)
    else {
        nextAllowed = today0730;
        // console.log(
        //     "آخر وردية مسائية بعد منتصف الليل → nextAllowed:",
        nextAllowed.toLocaleString();
        // );
    }

    // =========================
    // عرض الزر أو العدّاد
    // =========================
    if (now < nextAllowed) {
        if (btn) btn.style.display = "none";
        if (countdownDiv) countdownDiv.style.display = "block";

        function updateCountdown() {
            const now2 = new Date();
            let diff = nextAllowed - now2;

            if (diff <= 0) {
                if (countdownDiv) countdownDiv.style.display = "none";
                if (btn) btn.style.display = "block";
                // console.log("يمكن فتح الوردية الآن");
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            diff %= 1000 * 60 * 60;
            const minutes = Math.floor(diff / (1000 * 60));
            diff %= 1000 * 60;
            const seconds = Math.floor(diff / 1000);

            if (countdownDiv) {
                countdownDiv.textContent = `⏳ سيفتح التسجيل بعد: ${hours}سا ${minutes}د ${seconds}ث`;
            }

            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();
    } else {
        if (btn) btn.style.display = "block";
        if (countdownDiv) countdownDiv.style.display = "none";
        // console.log("يمكن فتح الوردية الآن");
    }
}

function toggleNavBar() {
    const navBar = document.getElementById("navBar");
    if (navBar) {
        if (navBar.style.display === "none" || navBar.style.display === "") {
            navBar.style.display = "flex";
        } else {
            navBar.style.display = "none";
        }
    }
}

function loadAnalysis() {
    const single = document.getElementById("singleDate").value;
    const from = document.getElementById("rangeFrom").value;
    const to = document.getElementById("rangeTo").value;

    let finalFrom = "";
    let finalTo = "";

    // لا يوجد تاريخ
    if (!single && !from && !to) {
        fetch(`/records`)
            .then((res) => res.json())
            .then(updateAnalysisUI)
            .catch((err) => console.error(err));
        return;
    }

    // تاريخ واحد
    if (single) {
        finalFrom = single;
        finalTo = single;
    } else {
        // فترة
        finalFrom = from;
        finalTo = to;
    }

    fetch(`/records?from=${finalFrom}&to=${finalTo}`)
        .then((res) => res.json())
        .then(updateAnalysisUI)
        .catch((err) => console.error(err));
}

function loadWorkersForAnalysis() {
    startProgress();
    fetch("/get_workers")
        .then((res) => res.json())
        .then((data) => {
            const select = document.getElementById("workerAnalysisSelect");
            const selectRS = document.getElementById("requestShiftSelect");
            select.innerHTML = `<option value="">اختر عامل...</option>`;
            selectRS.innerHTML = `<option value="">اختر عامل...</option>`;

            data.forEach((worker) => {
                select.innerHTML += `
                    <option value="${worker.id}">${worker.name}</option>
                `;

                selectRS.innerHTML += `
                    <option value="${worker.id}">${worker.name}</option>
                `;
            });
        });
}

function sendShiftRequest() {
    const receiverId = document.getElementById("requestShiftSelect").value;
    const date = document.getElementById("rsDate").value;
    const time = document.getElementById("rsTime").value;

    fetch("/shift-request/send", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({
            receiver_id: receiverId,
            date,
            time,
        }),
    })
        .then((res) => res.json())
        .then(() => {
            alert("تم إرسال طلب الوردية بنجاح");
            //اعادة تفعيل الزر
            document.getElementById("sendShiftRequestBtn").disabled = false;
        });
}

function loadWorkerStats() {
    const id = document.getElementById("workerAnalysisSelect").value;

    if (!id) {
        document.getElementById("workerStatsCards").style.display = "none";
        return;
    }

    fetch(`/worker_stats/${id}`)
        .then((res) => res.json())
        .then((data) => {
            document.getElementById("workerStatsCards").style.display = "block";

            document.getElementById("ws_days").textContent = data.days;
            document.getElementById("ws_transactions").textContent =
                data.transactions;
            document.getElementById("ws_expenses").textContent =
                data.expenses + " DA";
            document.getElementById("ws_shifts").textContent =
                data.shifts + " DA";
        });
}

function updateAnalysisUI(data) {
    let cash = 0,
        fridge = 0,
        salary = 0;

    data.data.forEach((r) => {
        if (r.type === "نقد") cash += Number(r.amount);
        if (r.type === "ثلاجة") fridge += Number(r.amount);
        if (r.type === "راتب") salary += Number(r.amount);
    });

    document.getElementById("sumCash").textContent =
        cash.toLocaleString() + " DA";
    document.getElementById("sumFridge").textContent =
        fridge.toLocaleString() + " DA";
    document.getElementById("sumSalary").textContent =
        salary.toLocaleString() + " DA";

    document.getElementById("totalWorkers").textContent = Number(
        data.totalWorkers,
    );
    document.getElementById("totalCustomers").textContent = Number(
        data.totalCustomers,
    );
    document.getElementById("total").textContent =
        Number(data.total).toLocaleString() + " DA";
    finishProgress();
}

function loadPeople() {
    fetch("/people")
        .then((res) => res.json())
        .then((data) => {
            const person = document.getElementById("personSelect");
            const search = document.getElementById("searchName");

            person.innerHTML = '<option value="">اختر الشخص...</option>';
            search.innerHTML = '<option value="">الكل</option>';

            data.forEach((user) => {
                // قائمة إدخال السجلات
                const opt1 = document.createElement("option");
                opt1.value = user.id;
                opt1.textContent = user.name;
                person.appendChild(opt1);

                // قائمة البحث
                const opt2 = document.createElement("option");
                opt2.value = user.id;
                opt2.textContent = user.name;
                search.appendChild(opt2);
            });
            finishProgress();
        })
        .catch((err) => console.error(err));
}

function loadRecords(nameFilter = "", typeFilter = "", from = "", to = "") {
    const url = `/records?id=${encodeURIComponent(nameFilter)}&type=${encodeURIComponent(typeFilter)}&from=${from}&to=${to}`;

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            records = data;

            render(records);
            finishProgress();
        })
        .catch((err) => console.error(err));
}

function addUser() {
    const roleS = document.getElementById("selectUserType").value;
    const name = document.getElementById("username").value;
    const email = document.getElementById("useremail").value;
    const pass = document.getElementById("userpass").value;
    const cpass = document.getElementById("usercpass").value;

    if (!name) {
        alert("ادخل اسم المستخدم");
        return;
    }

    if (role === "manager" && (roleS === "manager" || roleS === "worker")) {
        if (!email || !pass || !cpass) {
            alert("املأ جميع الحقول ");
            return;
        }

        if (pass !== cpass) {
            alert("كلمة المرور غير متطابقة");
            return;
        }
    }

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const bodyData =
        role === "manager" || role === "worker"
            ? `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(pass)}&role=${roleS}`
            : `name=${encodeURIComponent(name)}&role=${roleS}`; // customer فقط

    fetch("/add_user", {
        method: "POST",
        credentials: "same-origin", // مهم لإرسال الكوكيز الخاصة بالجلسة
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken, // <-- هنا نرسل الـ CSRF token في الهيدر
        },
        body: bodyData,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                alert("تمت الإضافة بنجاح");

                loadPeople(); // تحديث القائمة
            } else {
                alert(data.message);
            }

            //اعادة تفعيل الزر
            document.getElementById("addUserBtn").disabled = false;
            finishProgress();
        });
}

function render(records) {
    const table = document.getElementById("recordsTable");
    const pagintion = document.getElementById("pagintion");

    table.innerHTML = "";

    // -------- Pagination --------
    let html = `<nav><ul class="pagination justify-content-center">`;
    // console.log(records);

    records.pagination.links.forEach((link) => {
        html += `
        <li class="page-item ${link.active ? "active" : ""} ${link.url === null ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadUrl('${link.url}')">
                ${link.label}
            </a>
        </li>`;
    });

    html += `</ul></nav>`;
    pagintion.innerHTML = html;

    let total = 0;

    // ----------- تحقق من كون البيانات فارغة -----------
    if (!records.data || records.data.length === 0) {
        table.innerHTML = `
            <tr>
                <td colspan="8" class="text-center text-muted">لا توجد بيانات</td>
            </tr>
        `;

        document.getElementById("totalAmount").textContent = "0";
        return; // خروج لأنو ما كاش بيانات
    }

    // ----------- إذا كانت البيانات موجودة -----------
    records.data.forEach((r) => {
        let rowClass = "";
        let validationButton = "";
        let checkbox = "";
        let deleteButton = "";

        if (role === "manager") {
            checkbox = `<input type="checkbox" class="record-checkbox" value="${r.id}">`;
            deleteButton = `<button class='btn btn-danger btn-sm' onclick="deleteRecord(${r.id})">حذف</button>`;
            validationButton = `<button class='btn btn-primary btn-sm' onclick="verifyRecord(${r.id})">تحقق</button>`;
            rowClass = r.verified == 1 ? "table-success" : "table-warning";
        }

        const row = `<tr>
            <td>${checkbox}</td>
            <td class="status-cell ${rowClass}"></td>
            <td>${r.user?.name ?? ""}</td>
            <td>${r.amount}</td>
            <td>${r.type}</td>
            <td>${r.date}</td>
            <td>${r.time}</td>
            <td class="d-flex justify-content-center gap-2">
                 ${validationButton}
                 ${deleteButton}
            </td>
        </tr>`;

        table.innerHTML += row;

        total += Number(r.amount);
    });

    document.getElementById("totalAmount").textContent = total.toLocaleString();

    // -------- Select All + Multi Verify --------
    const selectAllCheckbox = document.getElementById("selectAllCheckbox");
    const multiVerifyBtn = document.getElementById("multiVerifyBtn");

    if (role === "manager") {
        selectAllCheckbox.style.display = "inline-block";
        multiVerifyBtn.style.display = "inline-block";
        selectAllCheckbox.checked = false;

        selectAllCheckbox.addEventListener("change", function () {
            const checked = this.checked;
            document
                .querySelectorAll(".record-checkbox")
                .forEach((cb) => (cb.checked = checked));
        });

        document.querySelectorAll(".record-checkbox").forEach((cb) => {
            cb.addEventListener("change", function () {
                const allChecked = Array.from(
                    document.querySelectorAll(".record-checkbox"),
                ).every((c) => c.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });
    } else {
        selectAllCheckbox.style.display = "none";
        multiVerifyBtn.style.display = "none";
    }
}

function loadUrl(url) {
    if (!url) return;

    fetch(url)
        .then((res) => res.json())
        .then((data) => render(data));
}

function openGRHmodal() {
    const modal = new bootstrap.Modal(document.getElementById("grhModal"));
    modal.show();

    // تحميل الأشخاص (من users)
    fetch("/people") // أو /users حسب مسارك في لارافيل
        .then((r) => r.json())
        .then((list) => {
            const select = document.getElementById("grhPerson");
            select.innerHTML = "";

            list.forEach((user) => {
                let opt = document.createElement("option");
                opt.value = user.id; // ID من جدول users
                opt.textContent = user.name;
                select.appendChild(opt);
            });

            if (list.length > 0) {
                // تعيين أول شخص تلقائياً
                select.value = list[0].id;

                // نعطي وقت قصير قبل تحميل بيانات GRH
                setTimeout(() => loadGRHdata(), 50);
            }
        })
        .catch((err) => console.error("Error loading users:", err));

    // تحديث البيانات عند تغيير المستخدم
    document.getElementById("grhPerson").onchange = loadGRHdata;
}

// استدعاءها بعد تحميل بيانات GRH
function loadGRHdata() {
    const id = document.getElementById("grhPerson").value;
    if (!id) return console.error("No ID selected!");

    // 🔥 مسار Laravel الصحيح
    fetch(`/grh/${id}`)
        .then((r) => r.json())
        .then((data) => {
            if (data.error) return console.error(data.error);

            // السحبات المالية (transactions)
            const tBody = document.getElementById("grhTransactions");
            tBody.innerHTML = "";
            data.transactions.forEach((t) => {
                const v = t.verified == 1 ? "table-success" : "table-warning";
                tBody.innerHTML += `
          <tr data-verified="${t.verified}" data-amount="${t.amount}">
            <td class="${v}"></td>
            <td>${t.date}</td>
            <td>${t.time}</td>
            <td>${t.amount} DA</td>
          </tr>`;
            });

            // الورديات (shifts)
            const sBody = document.getElementById("grhShifts");
            sBody.innerHTML = "";
            data.shifts.forEach((s) => {
                const v = s.verified == 1 ? "table-success" : "table-warning";
                sBody.innerHTML += `
          <tr data-verified="${s.verified}" data-amount="1600">
            <td class="${v}"></td>
            <td>${s.date}</td>
            <td>${s.time}</td>
            <td>1600 DA</td>
          </tr>`;
            });

            // زر التحقق العام
            updateVerifyAllBtnState();

            // حالة التحقق العامة
            document.getElementById("checkedYes").checked = data.verified == 1;
            document.getElementById("checkedNo").checked = data.verified == 0;

            // الفلاتر
            applyFilter();
            updateTotals();
            finishProgress();
        })
        .catch((err) => console.error("GRH Load Error:", err));
}

function applyFilter() {
    const yes = document.getElementById("checkedYes");
    const no = document.getElementById("checkedNo");

    let filter = null;
    if (yes.checked) filter = 1;
    if (no.checked) filter = 0;

    // فلترة السحبات
    document.querySelectorAll("#grhTransactions tr").forEach((row) => {
        let v = row.dataset.verified;

        // null كـ string تعامل كـ 0
        if (v === "null" || v === undefined || v === "" || v == null) v = "0";

        if (filter === null) {
            row.style.display = "";
        } else if (filter == 1) {
            row.style.display = v == "1" ? "" : "none";
        } else if (filter == 0) {
            row.style.display = v == "0" ? "" : "none";
        }
    });

    // فلترة الورديات
    document.querySelectorAll("#grhShifts tr").forEach((row) => {
        let v = row.dataset.verified;

        if (v === "null" || v === undefined || v === "" || v == null) v = "0";

        if (filter === null) {
            row.style.display = "";
        } else if (filter == 1) {
            row.style.display = v == "1" ? "" : "none";
        } else if (filter == 0) {
            row.style.display = v == "0" ? "" : "none";
        }
    });

    updateTotals();
}

function verifyAll() {
    const id = document.getElementById("grhPerson").value;

    if (!id) return;
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // إرسال طلب تحديث كل السجلات
    fetch("/grh_verify_all", {
        method: "POST",
        credentials: "same-origin", // مهم لإرسال الكوكيز الخاصة بالجلسة
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken, // <-- هنا نرسل الـ CSRF token في الهيدر
        },
        body: "id=" + id,
    })
        .then((r) => r.json())
        .then((res) => {
            if (res.status === "success") {
                // تغيير الصفوف مباشرة في الواجهة
                document
                    .querySelectorAll("#grhTransactions tr")
                    .forEach((row) => {
                        row.dataset.verified = "1";
                        row.querySelector("td").className = "table-success";
                    });

                document.querySelectorAll("#grhShifts tr").forEach((row) => {
                    row.dataset.verified = "1";
                    row.querySelector("td").className = "table-success";
                });

                // إظهار حالة التحقق
                document.getElementById("checkedYes").checked = true;
                document.getElementById("checkedNo").checked = false;

                // تطبيق الفلترة مباشرة (في حال كان checkbox مفعّل)
                applyFilter();

                // حساب المجاميع
                updateTotals();
                updateVerifyAllBtnState();

                finishProgress();
                alert("✔ تم التحقق من كل السجلات بنجاح!");

            //اعادة تفعيل الزر
                document.getElementById("verifyAllBtn").disabled = false;
            }
        });
}

function updateVerifyAllBtnState() {
    const btn = document.getElementById("verifyAllBtn");

    const allRows = [
        ...document.querySelectorAll("#grhTransactions tr"),
        ...document.querySelectorAll("#grhShifts tr"),
    ];

    if (allRows.length === 0) {
        btn.disabled = true;
        return;
    }

    const allVerified = allRows.every(
        (row) => Number(row.dataset.verified) === 1,
    );

    btn.disabled = allVerified;
}

// استدعاءها بعد أي تعديل يدوي على checkboxes أو بعد التحقق الكلي
document
    .getElementById("checkedYes")
    .addEventListener("change", updateVerifyAllBtnState);
document
    .getElementById("checkedNo")
    .addEventListener("change", updateVerifyAllBtnState);

function updateTotals() {
    let totalWithdraw = 0;
    let totalShifts = 0;

    // مجموع السحبات
    document.querySelectorAll("#grhTransactions tr").forEach((row) => {
        const amount = parseFloat(row.dataset.amount || 0);
        if (row.style.display !== "none") totalWithdraw += amount;
    });

    // مجموع الورديات
    document.querySelectorAll("#grhShifts tr").forEach((row) => {
        const amount = parseFloat(row.dataset.amount || 0);
        if (row.style.display !== "none") totalShifts += amount;
    });

    document.getElementById("totalWithdraw").textContent = totalWithdraw;
    document.getElementById("totalShifts").textContent = totalShifts;

    const net = totalShifts - totalWithdraw;
    document.getElementById("netSalary").textContent = net;
}

function updateTotals() {
    let totalWithdraw = 0;
    let totalShifts = 0;

    const rows = {
        withdraw: document.querySelectorAll("#grhTransactions tr"),
        shifts: document.querySelectorAll("#grhShifts tr"),
    };

    rows.withdraw.forEach((row) => {
        if (row.style.display !== "none") {
            totalWithdraw += Number(row.dataset.amount || 0);
        }
    });

    rows.shifts.forEach((row) => {
        if (row.style.display !== "none") {
            totalShifts += Number(row.dataset.amount || 0);
        }
    });

    const net = totalShifts - totalWithdraw;

    // تحديث الواجهة مع تنسيق الأرقام
    document.getElementById("totalWithdraw").textContent =
        totalWithdraw.toLocaleString() + " DA";

    document.getElementById("totalShifts").textContent =
        totalShifts.toLocaleString() + " DA";

    document.getElementById("netSalary").textContent =
        net.toLocaleString() + " DA";
}

function addRecord() {
    const id = document.getElementById("personSelect").value;
    const amount = document.getElementById("amountInput").value.trim();
    const type = document.getElementById("typeSelect").value;

    if (!id || !amount || !type) return alert("املأ كل الحقول");

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const body = `id=${encodeURIComponent(id)}&amount=${encodeURIComponent(amount)}&type=${encodeURIComponent(type)}`;

    fetch("/add_record", {
        method: "POST",
        credentials: "same-origin", // مهم لإرسال الكوكيز الخاصة بالجلسة
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken, // <-- هنا نرسل الـ CSRF token في الهيدر
        },
        body: body,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                alert("تمت الإضافة بنجاح");
                loadRecords();

                document.getElementById("amountInput").value = "";

                if (role === "manager") {
                    loadAnalysis();
                }
            } else {
                alert(data.message);
            }

            document.getElementById("addRecordBtn").disabled = false;

            finishProgress();
        })
        .catch((err) => console.error(err.message));
}

function verifyRecord(id) {
    if (role !== "manager") return alert("التحقق مسموح للمدير فقط");

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/verify", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: `id=${id}`,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                alert("تمت التحقق بنجاح");
                loadRecords();
            } else {
                alert("فشل التحقق");
            }

            finishProgress();
        });
}

function verifySelectedRecords() {
    const ids = Array.from(
        document.querySelectorAll(".record-checkbox:checked"),
    )
        .map((c) => c.value)
        .join(",");

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/verify_multiple", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: `ids=${ids}`,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                alert("تمت التحقق بنجاح");
                loadRecords();
            }

            finishProgress();
        });
}

function deleteRecord(id) {
    if (role !== "manager") return alert("الحذف مسموح للمدير فقط");

    if (!confirm("هل أنت متأكد من الحذف؟")) return;

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/delete", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: `id=${id}`,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                loadRecords();

                if (role === "manager") {
                    loadAnalysis();
                }
            } else {
                alert(data.message);
            }

            finishProgress();
        });
}

function deleteSelectedRecords() {
    if (role !== "manager") return alert("الحذف مسموح للمدير فقط");

    const checkboxes = document.querySelectorAll(".record-checkbox:checked");
    if (checkboxes.length === 0)
        return alert("اختر على الأقل معاملة واحدة للحذف");

    if (!confirm(`هل أنت متأكد من حذف ${checkboxes.length} معاملة؟`)) return;

    const ids = Array.from(checkboxes)
        .map((cb) => cb.value)
        .join(",");

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/delete_multiple", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: `ids=${encodeURIComponent(ids)}`,
    })
        .then((res) => res.text()) // نقرأ النص أولاً
        .then((text) => {
            //console.log("Response text:", text); // هذا يساعدك تشوف شو رجع السيرفر
            return JSON.parse(text); // parse بعد التأكد
        })
        .then((data) => {
            if (data.status === "success") {
                loadRecords();
                role = localStorage.getItem("role");

                if (role === "manager") {
                    loadAnalysis();
                }
            } else {
                alert(data.message);
            }

            finishProgress();
        })
        .catch((err) => console.error("JSON parse error:", err));
}

function exportXLSX() {
    fetch("/records")
        .then((res) => res.json())
        .then((data) => {
            finishProgress();
            if (data.length === 0) {
                alert("لا توجد بيانات للتصدير");
                return;
            }

            const sheetData = [["id", "الاسم", "المبلغ", "التاريخ", "الوقت"]];
            data.forEach((r) =>
                sheetData.push([r.id, r.user?.name, r.amount, r.date, r.time]),
            );

            const ws = XLSX.utils.aoa_to_sheet(sheetData);
            ws["!cols"] = [
                { wch: 7 },
                { wch: 20 },
                { wch: 10 },
                { wch: 15 },
                { wch: 12 },
            ];

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Transactions");
            XLSX.writeFile(wb, "transactions.xlsx");
        });
}

function toggleDateMode() {
    const check = document.getElementById("toggleRange").checked;

    const single = document.getElementById("singleDateBox");
    const range = document.getElementById("rangeBox");

    if (check) {
        // إظهار من - إلى
        range.style.setProperty("display", "flex", "important");

        // إخفاء التاريخ المفرد
        single.style.setProperty("display", "none", "important");

        document.getElementById("singleDate").value = "";
    } else {
        // إظهار التاريخ المفرد
        single.style.setProperty("display", "block", "important");

        // إخفاء من - إلى
        range.style.setProperty("display", "none", "important");

        document.getElementById("rangeFrom").value = "";
        document.getElementById("rangeTo").value = "";
    }

    loadAnalysis();
}

// تشغيل الفلترة تلقائياً عند أي تغيير
document.getElementById("searchName").addEventListener("change", autoFilter);
document.getElementById("searchType").addEventListener("change", autoFilter);
document.getElementById("fromDate").addEventListener("change", autoFilter);
document.getElementById("toDate").addEventListener("change", autoFilter);
document
    .getElementById("selectUserType")
    .addEventListener("change", updateAddUserModalSatys);

function updateAddUserModalSatys() {
    if (role === "manager") {
        const selectUserType = document.getElementById("selectUserType");
        const useremail = document.getElementById("useremail");
        const userpass = document.getElementById("userpass");
        const usercpass = document.getElementById("usercpass");

        selectUserType.style.display = "block";

        if (selectUserType.value !== "customer") {
            useremail.style.display = "block";
            userpass.style.display = "block";
            usercpass.style.display = "block";
        } else {
            useremail.style.display = "none";
            userpass.style.display = "none";
            usercpass.style.display = "none";
        }
    }
}

function autoFilter() {
    const nameFilter = document.getElementById("searchName").value;
    const typeFilter = document.getElementById("searchType").value.trim();
    const from = document.getElementById("fromDate").value;
    const to = document.getElementById("toDate").value;

    loadRecords(nameFilter, typeFilter, from, to);
}

function saveShift() {
    let now = new Date();
    let date = now.toISOString().slice(0, 10);
    let time = now.toTimeString().slice(0, 8);

    startProgress(); // يبدأ البروغرس بار

    fetch("/save-shift", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({
            user_id: id,
            date: date,
            time: time,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            finishProgress(); // ينهي البروغرس بار

            if (data.status === "success") {
                alert("تم تسجيل الوردية بنجاح");
                bootstrap.Modal.getInstance(
                    document.getElementById("shiftModal"),
                ).hide();
                localStorage.setItem("lastShiftTime", new Date().toISOString());
                checkShiftButton();
            } else {
                alert("حدث خطأ: " + data.message);
            }
        })
        .catch((err) => {
            finishProgress();
            alert("خطأ في الاتصال");
        });
}

// ========================
// Button Deactivation Logic
// ========================

function initializeButtonDeactivation() {
    document.addEventListener(
        "click",
        function (event) {
            const clickedButton = event.target.closest("button");

            if (!clickedButton) return;

            // Allow form submissions to go through without deactivation
            if (
                clickedButton.type === "submit" &&
                clickedButton.closest("form")
            ) {
                return; // Let the form submit naturally
            }

            // Check if this button is in the excluded list
            const isExcluded = checkIfExcluded(clickedButton);

            clickedButton.disabled = true;

            if (isExcluded) {
                // Re-enable other buttons after the configured timeout
                setTimeout(() => {
                    clickedButton.disabled = false;
                }, BUTTON_DISABLE_TIMEOUT);
            }
        },
        true,
    ); // Use capture phase to catch clicks early
}

function checkIfExcluded(button) {
    // Check if button ID matches any of the excluded buttons
    const excludedIds = [
        "logoutBtn",
        "openShiftModal",
        "openGRH",
        "toggleNavBtn",
        "clearLocalStorageBtn",
        "openAddUserModal",
        "closeModal",
    ];
    return excludedIds.includes(button.id);
}

// Initialize button deactivation when DOM is ready
// (This is now called from the main DOMContentLoaded handler above)
