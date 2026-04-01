@component('mail::message')
    # تم التحقق من معاملة رقم:{{ $id }}<br>

    تم التحقق من العملية بنجاح.
    @component('mail::panel')
        يرجى التحقق من النظام.
    @endcomponent

    شكراً،
    {{ config(key: 'app.name') }}
@endcomponent
