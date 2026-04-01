@component('mail::message')
     ## تم حذف معاملة<br>
    > **الاسم:** {{ $record['name'] }}<br>
    > **المبلغ:** {{ $record['amount'] }}<br>
    > **النوع:** {{ $record['type'] }}<br>
    > **التاريخ:** {{ $record['date'] }}<br>
    > **الوقت:** {{ $record['time'] }}<br>

    تم تنفيذ الحذف بتاريخ: ## {{ date('Y-m-d H:i') }}##
    @component('mail::panel')
        يرجى التحقق من النظام.
    @endcomponent

    شكراً،
    {{ config(key: 'app.name') }}
@endcomponent
