<?php

namespace App\Http\Controllers;

use App\Mail\ShiftCreatedMail;
use App\Mail\TransactionCreatedMail;
use App\Models\Shift;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $key = env('APP_ENV');
        return view('dashboard', [
            "role" => auth()->user()->role,
            "key" => $key
        ]);
    }

    public function records(Request $request)
    {
        $user = auth()->user();

        $query = Transaction::query();

        if ($user->role === 'worker') {
            $query->where('user_id', $user->id);
        }

        if ($request->id) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->id);
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->from && $request->to) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $records = $query
            ->with('user:id,name')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(25);

        // تحويل الـ links إلى array صالح للـ JS
        $links = [];
        foreach ($records->links()->elements as $element) {
            if (is_array($element)) {
                foreach ($element as $label => $url) {
                    $links[] = [
                        'label' => $label,
                        'url' => $url,
                        'active' => $records->currentPage() == $label,
                    ];
                }
            }
        }

        // الإحصائيات
        $totalWorkers = User::where('role', 'worker')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $total = $query->sum('amount');

        return response()->json([
        'data' => $records->items(),
        'pagination' => [
            'current_page' => $records->currentPage(),
            'last_page' => $records->lastPage(),
            'links' => $links,
        ],
        'totalWorkers' => $totalWorkers,
        'totalCustomers' => $totalCustomers,
        'total' => $total,
    ]);
    }




    public function addRecords(Request $request)
    {

        try {
            Transaction::create([
                'user_id' => $request->id,
                'amount' => $request->amount,
                'type' => $request->type,
                'date' => now()->toDateString(),   // تاريخ فقط (YYYY-MM-DD)
                'time' => now()->toTimeString(),   // وقت فقط (HH:MM:SS)
            ]);


            if (config('app.env') !== "local") {

                $user = User::find($request->id);
                $recipients = User::where('role', 'manager')->pluck('email')->toArray();

                if (!empty($recipients)) {
                    Mail::to($recipients)
                        ->send(new TransactionCreatedMail(
                            $user->name,
                            $request->amount,
                            $request->type
                        ));
                }
            }


            return response()->json([
                'status' => 'success',
            ]);


        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function addUser(Request $request)
    {
        try {

            $role = $request->input('role');

            // 1️⃣ التحقق من البيانات حسب الدور
            if ($role === "manager" || $role === "worker") {

                // المدير + العامل → تحقق كامل
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:6',
                ]);

                $email = $validated['email'];
                $password = bcrypt($validated['password']);

            } else {

                // العميل → لا يظهر له إيميل أو كلمة مرور
                $request->validate([
                    'name' => 'required|string|max:255',
                ]);

                // إنشاء إيميل تلقائي
                $email = "customer_" . time() . "_" . rand(1000, 9999) . "@auto.local";

                // كلمة مرور تلقائية
                $generatedPass = Str::random(8);
                $password = bcrypt($generatedPass);
            }

            // 2️⃣ إنشاء المستخدم
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
            ]);

            // 3️⃣ رد JSON
            return response()->json([
                'status' => 'success',
            ]);

        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function store(Request $request)
    {
        try {
            $shift = Shift::create([
                'user_id' => $request->user_id,
                'date' => $request->date,
                'time' => $request->time,
                'verified' => 0
            ]);
            if (config('app.env') !== "local") {
                $user = User::find($request->user_id);

                // ========== إرسال الإيميل ==========
                $emails = User::where('role', 'manager')->pluck('email')->toArray();

                Mail::to($user)
                    ->bcc($emails)
                    ->send(new ShiftCreatedMail($user->name, $shift->date, $shift->time));

            }
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Artisan::call('migrate:rollback');
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get the last shift time recorded by ANY worker (shared across all workers)
     * This ensures all workers see the same countdown and cannot bypass it
     */
    public function getLastShiftTime()
    {
        try {
            // Get the most recent shift from ANY worker (not just current user)
            $lastShift = Shift::orderBy('created_at', 'desc')->first();

            if (!$lastShift) {
                return response()->json([
                    'status' => 'success',
                    'lastShiftTime' => null
                ]);
            }

            // Combine date and time into ISO format
            $lastShiftDateTime = \Carbon\Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $lastShift->date . ' ' . $lastShift->time
            )->toIso8601String();

            return response()->json([
                'status' => 'success',
                'lastShiftTime' => $lastShiftDateTime
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

}


