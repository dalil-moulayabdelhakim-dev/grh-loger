<!DOCTYPE html>
<html lang="ar">

<head>
    @include('layout.head')
</head>

<body>

<div class="d-flex justify-content-center align-items-center p-5">
    <div class="card shadow p-5" style="max-width: 600px; width: 100%;">

        <h3 class="fw-bold mb-4 text-center text-success">✔ تم قبول الوردية</h3>

        <p><strong>التاريخ:</strong> {{ $date }}</p>
        <p><strong>الوقت:</strong> {{ $time }}</p>

    </div>
</div>

</body>
</html>
