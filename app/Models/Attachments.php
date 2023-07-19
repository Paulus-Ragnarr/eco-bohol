<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $fillable = [
        'attachment',
        'attachmentFor',
        'attachmentFilename',
    ];
    protected $primaryKey = 'attachment_id';
}
