<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
</head>

<body>
    <div class="justify-content-center align-items-center p-5">
        <div class="card shadow justify-content-center p-5">
            <h3>تم رفض طلب الوردية</h3>

            <p>
                مرحباً،
                نأسف لإبلاغك بأن طلب الوردية الخاص بك قد تم<strong>رفضه</strong> .
            </p>

            <hr>

            <h3>

                تفاصيل الوردية المرفوضة:
            </h3>

            <p>
                <strong> التاريخ: </strong> {{ $date }}
            </p>
            <p>
                <strong>الوقت:</strong> {{ $time }}
            </p>


            <hr>

            <h3>سبب الرفض:</h3> 

            <p>

                > {{ $reason }}
            </p>


            <hr>

            {{ config('app.name') }}

        </div>
    </div>


</body>

</html>
