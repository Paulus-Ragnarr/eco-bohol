<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeciesInfo extends Model
{
    use HasFactory;

    //Relationships

    public function species_record(){
        return $this->belongsTo(SpeciesRecord::class, 'species_id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function plantation(){
        return $this->belongsTo(Plantation::class, 'infotype_id');
    }

    protected $primaryKey = 'species_infos_id';
    protected $fillable = ['species_id', 'location_id', 'infotype_id', 'infotype', 'intensity_count'];
}