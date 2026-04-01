<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id'=>7,  'user_id'=>5,  'amount'=>500.00,  'date'=>'2025-11-20','time'=>'07:48:44','type'=>'نقد','verified'=>0],
            ['id'=>12, 'user_id'=>13, 'amount'=>400.00,  'date'=>'2025-11-21','time'=>'15:47:39','type'=>'نقد','verified'=>1],
            ['id'=>13, 'user_id'=>9,  'amount'=>1100.00, 'date'=>'2025-11-22','time'=>'06:20:01','type'=>'نقد','verified'=>1],
            ['id'=>14, 'user_id'=>12, 'amount'=>500.00,  'date'=>'2025-11-22','time'=>'12:50:06','type'=>'نقد','verified'=>0],
            ['id'=>15, 'user_id'=>7,  'amount'=>180.00,  'date'=>'2025-11-22','time'=>'15:50:40','type'=>'ثلاجة','verified'=>0],
            ['id'=>16, 'user_id'=>8,  'amount'=>80.00,   'date'=>'2025-11-22','time'=>'15:50:50','type'=>'ثلاجة','verified'=>0],
            ['id'=>17, 'user_id'=>8,  'amount'=>7000.00, 'date'=>'2025-11-22','time'=>'16:59:22','type'=>'نقد','verified'=>0],
            ['id'=>18, 'user_id'=>13, 'amount'=>21000.00,'date'=>'2025-11-22','time'=>'17:07:15','type'=>'نقد','verified'=>0],
            ['id'=>19, 'user_id'=>5,  'amount'=>500.00,  'date'=>'2025-11-23','time'=>'06:54:00','type'=>'نقد','verified'=>0],
            ['id'=>20, 'user_id'=>7,  'amount'=>16000.00,'date'=>'2025-11-23','time'=>'15:39:34','type'=>'نقد','verified'=>0],
            ['id'=>21, 'user_id'=>9,  'amount'=>8200.00, 'date'=>'2025-11-23','time'=>'18:29:09','type'=>'نقد','verified'=>1],
            ['id'=>23, 'user_id'=>7,  'amount'=>7000.00, 'date'=>'2025-11-24','time'=>'09:22:21','type'=>'نقد','verified'=>0],
            ['id'=>24, 'user_id'=>5,  'amount'=>500.00,  'date'=>'2025-11-24','time'=>'11:45:31','type'=>'نقد','verified'=>0],
            ['id'=>25, 'user_id'=>5,  'amount'=>500.00,  'date'=>'2025-11-24','time'=>'18:29:23','type'=>'نقد','verified'=>0],
            ['id'=>27, 'user_id'=>9,  'amount'=>500.00,  'date'=>'2025-11-25','time'=>'06:00:41','type'=>'نقد','verified'=>0],
            ['id'=>28, 'user_id'=>12, 'amount'=>500.00,  'date'=>'2025-11-25','time'=>'13:12:37','type'=>'نقد','verified'=>0],
            ['id'=>29, 'user_id'=>8,  'amount'=>100.00,  'date'=>'2025-11-25','time'=>'13:20:22','type'=>'ثلاجة','verified'=>0],
            ['id'=>30, 'user_id'=>8,  'amount'=>230.00,  'date'=>'2025-11-25','time'=>'14:42:45','type'=>'ثلاجة','verified'=>0],
            ['id'=>31, 'user_id'=>7,  'amount'=>100.00,  'date'=>'2025-11-25','time'=>'17:50:08','type'=>'ثلاجة','verified'=>0],
            ['id'=>32, 'user_id'=>7,  'amount'=>50.00,   'date'=>'2025-11-26','time'=>'12:17:33','type'=>'ثلاجة','verified'=>0],
            ['id'=>33, 'user_id'=>8,  'amount'=>350.00,  'date'=>'2025-11-26','time'=>'15:31:48','type'=>'ثلاجة','verified'=>0],
            ['id'=>34, 'user_id'=>12, 'amount'=>500.00,  'date'=>'2025-11-26','time'=>'17:13:05','type'=>'نقد','verified'=>0],
            ['id'=>35, 'user_id'=>5,  'amount'=>500.00,  'date'=>'2025-11-27','time'=>'06:38:30','type'=>'نقد','verified'=>0],
            ['id'=>36, 'user_id'=>5,  'amount'=>50.00,   'date'=>'2025-11-27','time'=>'06:44:49','type'=>'ثلاجة','verified'=>0],
            ['id'=>37, 'user_id'=>12, 'amount'=>500.00,  'date'=>'2025-11-27','time'=>'11:37:54','type'=>'نقد','verified'=>0],
            ['id'=>38, 'user_id'=>12, 'amount'=>500.00,  'date'=>'2025-11-27','time'=>'13:38:22','type'=>'نقد','verified'=>0],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = Carbon::now();
            $row['updated_at'] = Carbon::now();
        }

        DB::table('transactions')->insert($data);
    }
}
