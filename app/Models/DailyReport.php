<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_number',
        'user_id',
        'report_date',
        'status',
        'total_entries',
        'total_duration_minutes',
        'summary_notes',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workEntries()
    {
        return $this->hasMany(WorkEntry::class);
    }

    public function shareHistories()
    {
        return $this->hasMany(ReportShareHistory::class);
    }

    // Helper: Format Duration (Minutes to "X Hours Y Mins")
    public function getFormattedTotalDurationAttribute(): string
    {
        $hours = floor($this->total_duration_minutes / 60);
        $minutes = $this->total_duration_minutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} Hours {$minutes} Mins";
        } elseif ($hours > 0) {
            return "{$hours} Hours";
        } else {
            return "{$minutes} Mins";
        }
    }
}