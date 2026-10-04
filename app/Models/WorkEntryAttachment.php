<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkEntryAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_entry_id',
        'file_path',
        'file_type',
        'file_name',
    ];

    public function workEntry()
    {
        return $this->belongsTo(WorkEntry::class);
    }
}