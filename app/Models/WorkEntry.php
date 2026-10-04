<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_report_id',
        'branch_id',
        'asset_id',
        'title',
        'category',
        'description',
        'duration_minutes',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function attachments()
    {
        return $this->hasMany(WorkEntryAttachment::class);
    }
}