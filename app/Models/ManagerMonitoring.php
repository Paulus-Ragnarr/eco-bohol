<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerMonitoring extends Model
{
    use HasFactory;

    public function manager()
    {
        return $this->belongsto(Manager::class, 'manager_id');
    }
    public function plantation()
    {
        return $this->belongsTo(Plantation::class, 'plantation_id');
    }
    protected $primaryKey = 'monitor_id';
    protected $fillable = [
        'manager_id', 'plantation_id', 'date_monitored',
        'no_survived', 'no_dead', 'area', 'current_planted', 'remarks'
    ];
}
