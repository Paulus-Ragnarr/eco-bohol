<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailables\Attachment;

class OfficerMonitoring extends Model
{
    use HasFactory;

    public function plantation()
    {
        return $this->belongsTo(Plantation::class, 'plantation_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function monitorattachment()
    {
        return $this->hasMany(Attachments::class, 'file_id');
    }

    protected $primaryKey = 'monitor_id';
}
