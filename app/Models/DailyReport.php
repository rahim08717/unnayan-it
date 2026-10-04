<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_date',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workEntries()
    {
        return $this->hasMany(WorkEntry::class);
    }

    public function getTotalDurationAttribute()
    {
        $minutes = $this->workEntries->sum('duration_minutes');
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0) {
            return "{$hours} ঘণ্টা {$remainingMinutes} মিনিট";
        }
        return "{$remainingMinutes} মিনিট";
    }
}