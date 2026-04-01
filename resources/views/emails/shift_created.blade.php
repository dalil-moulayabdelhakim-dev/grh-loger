@component('mail::message')
# تنبيه: تم تسجيل وردية جديدة

**الموظف:** {{ $personName }}<br>
**التاريخ:** {{ $date }}<br>
**الوقت:** {{ $time }}<br>

@component('mail::panel')
يرجى التحقق من النظام.
@endcomponent

شكراً،
نظام الورديات
@endcomponent
