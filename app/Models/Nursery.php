<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Nursery extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();
 
        // Customize the data array...
        $array['nursery_address'] = $this->nursery_address;
        $array['date_established'] = $this->date_established;
 
        return $array;
    }

    public function manager(){
        return $this->belongsTo(Manager::class, 'manager_id');
    }
    public function batch_infos() {
        return $this->hasMany(BatchInfo::class, 'nursery_id');
    }
    protected $primaryKey = 'nursery_id';
}
