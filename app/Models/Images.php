<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'imageFor',
        'imageFilename',
    ];
    protected $primaryKey = 'image_id';
}
