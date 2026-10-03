<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportShareHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_report_id',
        'shared_via',
        'shared_to',
        'shared_by',
        'notes',
        'shared_at',
    ];

    protected $casts = [
        'shared_at' => 'datetime',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'shared_by');
    }
}