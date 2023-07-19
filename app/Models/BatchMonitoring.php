<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchMonitoring extends Model
{
    use HasFactory;

    public function batch_info() {
        return $this->belongsTo(BatchInfo::class, 'batch_id');

    
    }

    protected $primaryKey = 'monitor_id';
    protected $fillable = ['monitor_id', 'date_monitored', 'no_survived', 'no_dead', 'survival_rate', 'remarks', 'batch_id'];
}
