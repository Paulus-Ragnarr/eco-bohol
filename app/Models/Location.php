<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Location extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['latitude'] = $this->latitude;
        $array['longitude'] = $this->longitude;
        $array['barangay'] = $this->barangay;
        $array['town'] = $this->town;
        $array['cenro'] = $this->cenro;

        return $array;
    }

    public function species_infos(){
        return $this->hasMany(SpeciesInfo::class, 'location_id');
    }

    protected $primaryKey = 'location_id';
}
