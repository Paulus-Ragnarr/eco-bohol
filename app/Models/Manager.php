<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    public function manager_monitorings()
    {
        return $this->hasMany(ManagerMonitoring::class, 'manager_id');
    }

    public function nurserys()
    {
        return $this->hasMany(Nursery::class, 'manager_id');
    }

    public function plantations()
    {
        return $this->hasMany(Plantation::class, 'manager_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $primaryKey = 'manager_id';
    protected $fillable = [
        'manager_id',
        'manager_name',
        'manager_contact',
        'org_name',
        'org_type',
        'status'
    ];
}
