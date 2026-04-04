<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_start',
        'day_end',
        'night_start',
        'night_end',
    ];

    /**
     * Get the current shift settings (always returns single record)
     */
    public static function current()
    {
        return self::firstOrCreate(
            [],
            [
                'day_start' => '07:30',
                'day_end' => '19:30',
                'night_start' => '19:30',
                'night_end' => '07:30',
            ]
        );
    }
}
