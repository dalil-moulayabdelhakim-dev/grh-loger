@component('mail::message')

<div style="font-family: Arial; direction: rtl; text-align: right">

#  تم استلام الحساب<br>

**الموظف:** {{ $personName }}<br>
**من:** {{ $startDate }}<br>
**إلى:** {{ $endDate }}<br>

---

## التفاصيل المالية (غير المحققة)

**مجموع السحوبات:** {{ $totalTransactions }} دج<br>
**عدد الورديات:** {{ $totalShifts }}<br>
**تكلفة الورديات:** {{ $totalShiftCost }} دج<br>

---

##  المبلغ المستلم<br>

### **{{ $receivedAmount }} دج**<br>

---

تمت معالجة جميع السجلات الجديدة بنجاح.

</div>

@endcomponent
