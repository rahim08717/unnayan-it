<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_report_id',
        'work_category_id',
        'branch_id',
        'asset_id',
        'ticket_id',
        'employee_id',
        'title',
        'description',
        'department',
        'start_time',
        'end_time',
        'duration_minutes',
        'priority',
        'status',
        'problem',
        'action_taken',
        'solution',
        'result',
        'remarks',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function category()
    {
        return $this->belongsTo(WorkCategory::class, 'work_category_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function attachments()
    {
        return $this->hasMany(WorkEntryAttachment::class);
    }

    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }
}