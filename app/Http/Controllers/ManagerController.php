<?php

namespace App\Http\Controllers;

use App\Mail\AllGRHVerifiedMail;
use App\Mail\MultiRecordVerifiedMail;
use App\Mail\RecordDeleteMail;
use App\Mail\RecordVerifiedMail;
use App\Mail\ShiftApproverMail;
use App\Mail\ShiftRejectedMail;
use App\Mail\ShiftRequestMail;
use App\Models\Shift;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Transaction::where('user_id', $user->id);

        if ($request->from && $request->to) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        return response()->json($query->get());
    }

    public function getData($id)
    {
        try {

            // 1️⃣ التحقق من وجود المستخدم
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // 2️⃣ جلب المعاملات الخاصة به
            $transactions = Transaction::where('user_id', $id)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get();

            // 3️⃣ جلب الورديات الخاصة به
            $shifts = Shift::where('user_id', $id)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get();

            // 4️⃣ حالة التحقق العامة
            // إذا كل السجلات verified = 1 → verified عام = 1 وإلا 0
            $isVerified =
                $transactions->every(fn($t) => $t->verified == 1) &&
                $shifts->every(fn($s) => $s->verified == 1)
                ? 1
                : 0;

            // 5️⃣ إرجاع البيانات
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name
                ],
                'transactions' => $transactions,
                'shifts' => $shifts,
                'verified' => $isVerified
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyRecord(Request $request)
    {

        try {
            $record = Transaction::where('id', $request->id)->first();
            $record->verified = 1;
            $record->save();
            return response()->json([
                'status' => 'success',
            ]);

            if (config('app.env') !== 'local') {
                $managers = User::where('role', 'manager')->pluck('email')->toArray();
                if (!empty($recipients)) {
                    Mail::to($recipients)
                        ->send(new RecordVerifiedMail(
                            $request->id
                        ));
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ]);
        }
    }

    public function verifyMultipleRecord(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);

            if (!$ids || count($ids) === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'لا توجد عناصر للتحقق'
                ]);
            }

            // تحديث السجلات دفعة واحدة
            Transaction::whereIn('id', $ids)->update([
                'verified' => 1,
            ]);



            if (env("APP_ENV") !== "local") {
                $recipients = User::where('role', 'manager')->pluck('email')->toArray();

                if (!empty($recipients)) {
                    Mail::to($recipients)
                        ->send(new MultiRecordVerifiedMail());
                }
            }


            return response()->json([
                'status' => 'success',
            ]);

        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteRecord(Request $request)
    {

        try {
            $record = Transaction::where('id', $request->id)->first();
            $record->delete();

            if (config('app.env') !== 'local') {
                $managers = User::where('role', 'manager')->pluck('email')->toArray();

                Mail::to($managers)->send(new RecordDeleteMail(
                    $record->user->name,
                    $record->amount,
                    $record->type,
                    $record->date,
                    $record->time
                ));
            }

            return response()->json([
                'status' => 'success',
            ]);


        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');
            return response()->json([
                'status' => 'error',
                'message' => $e
            ]);
        }
    }

    public function deleteMultipleRecord(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);

            if (!$ids || count($ids) === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'لا توجد عناصر للتحقق'
                ]);
            }

            // تحديث السجلات دفعة واحدة
            Transaction::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
            ]);

        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

      public function grhVerifyAllRecord(Request $request)
    {
        try {
            $userId = $request->id;

            if (!$userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User ID is required'
                ]);
            }

            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ]);
            }



                // ================================
                // TRANSACTIONS (غير المحققة)
                // ================================
                $transactionQuery = Transaction::where('user_id', $userId)
                    ->where(function ($q) {
                        $q->where('verified', 0)->orWhereNull('verified');
                    });

                // عدد معاملاته غير المحققة
                $totalTransactions = $transactionQuery->count();

                // مجموع المبالغ غير المحققة
                $totalTransactionsAmount = $transactionQuery->sum('amount') ?? 0;

                // أول وآخر تاريخ للمعاملات غير المحققة
                $transactionDates = $transactionQuery
                    ->selectRaw('MIN(date) as first_date_t, MAX(date) as last_date_t')
                    ->first();

                $firstDate_T = $transactionDates->first_date_t;
                $lastDate_T = $transactionDates->last_date_t;


                // ================================
                // SHIFTS (غير المحققة)
                // ================================
                $shiftQuery = Shift::where('user_id', $userId)
                    ->where(function ($q) {
                        $q->where('verified', 0)->orWhereNull('verified');
                    });

                // عدد الورديات
                $totalShifts = $shiftQuery->count();

                // أول وآخر تاريخ ورديات
                $shiftDates = $shiftQuery
                    ->selectRaw('MIN(date) as first_date_s, MAX(date) as last_date_s')
                    ->first();

                $firstDate_S = $shiftDates->first_date_s;
                $lastDate_S = $shiftDates->last_date_s;


                // ================================
                // تحديد فترة العمل الكاملة
                // ================================
                $allStartDates = array_filter([$firstDate_T, $firstDate_S]);
                $allEndDates = array_filter([$lastDate_T, $lastDate_S]);

                $startDate = $allStartDates ? min($allStartDates) : null;
                $endDate = $allEndDates ? max($allEndDates) : null;


                // ================================
                // الحسابات المالية
                // ================================
                $shiftCost = 1600;

                $totalShiftCost = $totalShifts * $shiftCost;

                // المبلغ المستلم
                $receivedAmount = $totalShiftCost - $totalTransactionsAmount;

            // ================================
            // تحديث كل السجلات إلى verified = 1
            // ================================
            Transaction::where('user_id', $userId)->update(['verified' => 1]);
            Shift::where('user_id', $userId)->update(['verified' => 1]);

            if (config('app.env') !== 'local') {

                $managers = User::where('role', 'manager')->pluck('email')->toArray();
                // ================================
                // إرسال الإيميل
                // ================================
                Mail::to($user->email)
                    ->bcc($managers)
                    ->send(
                        new AllGRHVerifiedMail(
                            $user->name,
                            $startDate ?? "لا يوجد",
                            $endDate ?? "لا يوجد",
                            $totalTransactions,        // عدد السحوبات
                            $totalShifts,              // عدد الورديات
                            $totalShiftCost,           // تكلفة الورديات
                            $receivedAmount            // المبلغ المستلم
                        )
                    );
            }


            return response()->json([
                'status' => 'success',
                'message' => 'All records verified successfully'
            ]);

        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getWorkers()
    {
        $workers = User::where('role', 'worker')->get(['id', 'name']);
        return response()->json($workers);
    }


    public function workerStats($id)
    {
        // عدد أيام العمل
        $days = Shift::where('user_id', $id)
            ->distinct('date')
            ->count('date');

        // عدد التحويلات
        $transactions = Transaction::where('user_id', $id)->count();

        // مجموع مصاريف التحويلات
        $expenses = Transaction::where('user_id', $id)->sum('amount');


        // مجموع مبالغ الوردية
        $shiftSum = 1600 * $days;

        return response()->json([
            'days' => $days,
            'transactions' => $transactions,
            'expenses' => $expenses,
            'shifts' => $shiftSum,
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            "receiver_id" => "required",
            "date" => "required",
            "time" => "required"
        ]);

        $sender = auth()->user();
        $receiver = User::find($request->receiver_id);

        // الروابط الموقعة
        $baseData = [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'date' => $request->date,
            'time' => $request->time,
        ];

        $verifyUrl = URL::temporarySignedRoute(
            'shift.verify',
            now()->addHours(48),
            $baseData
        );

        // إرسال الإيميل
        Mail::to($receiver->email)->send(
            new ShiftRequestMail($sender, $request->date, $request->time, $verifyUrl)
        );

        return response()->json(["success" => true]);
    }


    // صفحة التحقق
    public function verify(Request $request)
    {
        $sender = User::find($request->sender_id);

        // حذف الكلمات المحجوزة
        $safeData = $request->except(['signature', 'expires']);

        return view('shift.verify', [
            'sender' => $sender,
            'date' => $safeData['date'],
            'time' => $safeData['time'],
            'approveUrl' => URL::signedRoute('shift.approve', $safeData),
            'rejectUrl' => URL::signedRoute('shift.reject', $safeData)
        ]);
    }


    // القبول
    public function approve(Request $request)
    {
        $sender = User::find($request->sender_id);

        Mail::to($sender->email)->send(
            new ShiftApproverMail($request->date, $request->time)
        );

        return view("shift.approved", [
        'date' => $request->date,
        'time' => $request->time
    ]);
    }


    // صفحة سبب الرفض
    public function rejectPage(Request $request)
    {
        return view("shift.reject", [
            'data' => $request->all()
        ]);
    }


    // إرسال سبب الرفض
    public function submitReject(Request $request)
    {
        $sender = User::find($request->sender_id);

        Mail::to($sender->email)->send(
            new ShiftRejectedMail(
                $request->date,
                $request->time,
                $request->reason
            )
        );

        return view("shift.rejected", [
                'date' => $request->date,
                'time' => $request->time,
                'reason' => $request->reason
        ]);
    }

    // Get shift settings
    public function getShiftSettings()
    {
        try {
            $settings = \App\Models\ShiftSetting::current();
            return response()->json([
                'status' => 'success',
                'data' => [
                    'day_start' => $settings->day_start,
                    'day_end' => $settings->day_end,
                    'night_start' => $settings->night_start,
                    'night_end' => $settings->night_end,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Update shift settings (Manager only)
    public function updateShiftSettings(Request $request)
    {
        try {
            $validated = $request->validate([
                'day_start' => 'required|date_format:H:i',
                'day_end' => 'required|date_format:H:i',
                'night_start' => 'required|date_format:H:i',
                'night_end' => 'required|date_format:H:i',
            ]);

            $settings = \App\Models\ShiftSetting::current();
            $settings->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'تم تحديث أوقات الورديات بنجاح',
                'data' => [
                    'day_start' => $settings->day_start,
                    'day_end' => $settings->day_end,
                    'night_start' => $settings->night_start,
                    'night_end' => $settings->night_end,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

}
