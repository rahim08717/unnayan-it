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
        'file_name',
        'file_type',
        'attachment_type',
        'mime_type',
        'file_size',
        'uploaded_by',
    ];

    public function workEntry()
    {
        return $this->belongsTo(WorkEntry::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}