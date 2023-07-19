<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class BatchInfo extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();
 
        // Customize the data array...
        $array['status'] = $this->status;
        $array['remarks'] = $this->remarks;
        $array['no_potted'] = $this->no_potted;
        $array['date_potted'] = $this->date_potted;
        $array['current_no_potted'] = $this->current_no_potted;
 
        return $array;
    }

    public function batch_monitorings() {
        return $this->hasMany(BatchMonitoring::class, 'batch_id');
    }

    public function purchase() {
        return $this->hasMany(Purchase:: class, 'batch_id');
    }

    public function nursery() {
        return $this->belongsTo(Nursery::class, 'nursery_id');
    }

    public function species_record() {
        return $this->belongsTo(SpeciesRecord::class, 'species_id');
    }

    protected $primaryKey = 'batch_id';
}
