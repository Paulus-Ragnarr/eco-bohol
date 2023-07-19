<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class SpeciesRecord extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();
 
        // Customize the data array...
        $array['mangrove_id'] = $this->mangrove_id;
        $array['scientific_name'] = $this->scientific_name;
        $array['common_name'] = $this->common_name;
        $array['conserv_status'] = $this->conserv_status;
        $array['kingdom'] = $this->kingdom;
        $array['phylum'] = $this->phylum;
        $array['class'] = $this->class;
        $array['order'] = $this->order;
        $array['family'] = $this->family;
        $array['genus'] = $this->genus;
 
        return $array;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function journals() {
        return $this->hasMany(Journal::class, 'species_id');
    }

    public function species_infos() {
        return $this->hasMany(SpeciesInfo::class, 'species_id');
    }

    public function batchinfos() {
        return $this->hasMany(BatchInfo::class, 'species_id');
    }

    protected $fillable = ['species_id', 'species_img', 'scientific_name', 'common_name', 'kingdom', 'phylum', 'class', 'order', 'family', 
                            'genus', 'species_descrp', 'propagule_img', 'propagule_descrp', 'flower_img', 'flower_descrp', 'style', 
                            'leaves_img', 'leaves_descrp', 'zonation', 'relev_com', 'conserv_status', 'status', 'user_id'];


    public function images() {
        return $this->hasMany(Images::class, 'species_record_id');
    }
    public function species_groups(){
        return $this->hasMany(Species_group::class, 'species_id');
    }


    public function getFillable()
    {
        return $this->fillable;
    }
    protected $guarded = ['species_id'];
    protected $primaryKey = 'species_id';
}
