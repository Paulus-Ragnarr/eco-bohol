<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function batch_info() {
        return $this->belongsTo(BatchInfo::class, 'batch_id');
    }

    protected $primaryKey = 'acquire_id';

    protected $fillable = ['acquire_id', 'current_no_potted', 'no_acquired', 'type', 'remarks', 'batch_id'];
}
