let progressInterval;

function startProgress() {
    const bar = document.getElementById("progress-bar");
    bar.style.display = "block";
    bar.style.width = "0%";

    let width = 0;
    clearInterval(progressInterval);

    progressInterval = setInterval(() => {
        width += Math.random() * 10; // يزيد بشكل وهمي
        if (width >= 90) width = 90; // ما يوصلش 100 حتى نكمل العملية
        bar.style.width = width + "%";
    }, 200);
}

function finishProgress() {
    const bar = document.getElementById("progress-bar");

    clearInterval(progressInterval);

    bar.style.width = "100%";

    setTimeout(() => {
        bar.style.display = "none";
        bar.style.width = "0%";
    }, 400);
}

startProgress()
