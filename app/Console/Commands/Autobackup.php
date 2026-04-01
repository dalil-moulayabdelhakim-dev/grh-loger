<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AutoBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run automatic backup';

    /**
     * Execute the console command.
     */
     public function handle()
    {
        $this->info('Starting backup...');

        try {
            // مثال باستخدام spatie/laravel-backup
            \Artisan::call('backup:run', [
                '--only-db' => true,   // إذا تريد نسخة من قاعدة البيانات فقط
                // '--only-files' => true,  // إذا تريد الملفات فقط
            ]);

            $this->info('Backup completed successfully!');
        } catch (\Exception $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            return 1; // خروج برمز خطأ إذا فشل
        }

        return 0; // نجاح العملية
    }
}
