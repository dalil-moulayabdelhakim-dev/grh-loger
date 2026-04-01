document.getElementById('shiftModal').addEventListener('show.bs.modal', function () {

    let now = new Date();

    let date = now.toISOString().slice(0, 10); // YYYY-MM-DD
    let time = now.toTimeString().slice(0, 8); // HH:MM:SS

    document.querySelector("#shiftModal .modal-body").innerHTML = `
            <h6 class="text-center">
                تسجيل الوردية<br>
                <b>التاريخ:</b> ${date}<br>
                <b>الوقت:</b> ${time}
            </h6>
        `;
});

function openAddUserModal() {
    const modalEl = document.getElementById("addUserModal");

    // إنشاء instance للمودال إذا لم تكن موجودة
    if (!window.addUserModalInstance) {
        window.addUserModalInstance = new bootstrap.Modal(modalEl, {
            backdrop: "static", // يمنع الإغلاق عند الضغط خارج المودال
        });
    }

    // فتح المودال بطريقة Bootstrap
    window.addUserModalInstance.show();
    updateAddUserModalSatys();
}



function openShiftModal() {
    const modalEl = document.getElementById("shiftModal");

    // إنشاء instance للمودال إذا لم تكن موجودة
    if (!window.shiftModalInstance) {
        window.shiftModalInstance = new bootstrap.Modal(modalEl, {
            backdrop: "static", // يمنع الإغلاق عند الضغط خارج المودال
        });
    }

    // فتح المودال بطريقة Bootstrap
    window.shiftModalInstance.show();
}
