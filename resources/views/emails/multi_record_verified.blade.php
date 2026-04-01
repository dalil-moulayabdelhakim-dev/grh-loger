@component('mail::message')
    # تم التحقق من معاملات:<br>

    تم التحقق من مجموعة من العمليا بنجاح.
    تم تنفيذ التحقق بتاريخ: ## {{ date('Y-m-d H:i') }}##
    @component('mail::panel')
        يرجى التحقق من النظام.
    @endcomponent

    شكراً،
    {{ config(key: 'app.name') }}
@endcomponent
