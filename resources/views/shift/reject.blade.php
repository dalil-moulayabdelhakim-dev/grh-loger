<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
</head>

<body>
    <div class="justify-content-center align-items-center p-5">
        <div class="card shadow justify-content-center p-5 ">
            <h5>سبب الرفض</h5>

            <form method="POST" action="{{ route('shift.reject.submit') }}">
                @csrf

                <textarea name="reason" class="form-control" rows="4" required></textarea>

                @foreach ($data as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <button class="btn btn-danger mt-3">إرسال</button>
            </form>
        </div>
    </div>


</body>

</html>
