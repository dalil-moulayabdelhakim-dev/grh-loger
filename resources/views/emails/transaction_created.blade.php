@component('mail::message')

<div style="font-family: Arial; direction: rtl; text-align: right">

# تفاصيل المعاملة الجديدة

**الاسم:** {{ $name }}<br>
**المبلغ:** {{ $amount }}<br>
**النوع:** {{ $type }}<br>
**التاريخ:** {{ $date }}<br>
**الوقت:** {{ $time }}<br>

---

تم إرسال هذه الرسالة تلقائيًا من نظام المعاملات.

</div>

@endcomponent
