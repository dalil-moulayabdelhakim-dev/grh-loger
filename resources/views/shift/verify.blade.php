<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
</head>

<body> 
    <div class="justify-content-center align-items-center p-5">
        <div class="card shadow justify-content-center p-5">
            <h2>تفاصيل طلب الوردية</h2>

            <p>الطالب: {{ $sender->name }}</p>
            <p>التاريخ: {{ $date }}</p>
            <p>الوقت: {{ $time }}</p>

            <a href="{{ $approveUrl }}" class="btn btn-success mb-3">قبول</a>
            <a href="{{ $rejectUrl }}" class="btn btn-danger">رفض</a>
        </div>
    </div>
</body>

</html>
