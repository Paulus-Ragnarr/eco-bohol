<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Plantation extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();
 
        // Customize the data array...
        $array['plantation_address'] = $this->plantation_address;
        $array['commodity'] = $this->commodity;
        $array['component'] = $this->component;
        $array['unique_code'] = $this->unique_code;
        $array['status'] = $this->status;
 
        return $array;
    }

    //Relationships

    public function species_infos()
    {
        return $this->hasMany(SpeciesInfo::class, 'infotype_id');
    }
    public function manager_monitorings()
    {
        return $this->hasMany(ManagerMonitoring::class, 'plantation_id');
    }
    public function officer_monitorings()
    {
        return $this->hasMany(OfficerMonitoring::class, 'plantation_id');
    }
    public function latest_officer_monitoring()
    {
        return $this->hasMany(OfficerMonitoring::class, 'plantation_id')->latest();
    }
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function loa_attachment()
    {
        return $this->hasMany(Attachments::class, 'file_id');
    }
    public function species_groups(){
        return $this->hasMany(Species_group::class, 'plantation_id');
    }

    protected $fillable = [
        'plantation_id',
        'unique_code',
        'region',
        'district',
        'cenro',
        'penro',
        'plantation_address',
        'component',
        'commodity',
        'species',
        'date_started',
        'total_area',
        'tenure',
        'fund_source',
        'target_loa',
        'no_loa',
        'target_no',
        'initial_no',
        'density_ha',
        'current_planted',
        'latitude',
        'longitude',
        'status',
        'remark', '
        loa_file',
        'manager_id'
    ];

    public function getFillable()
    {
        return $this->fillable;
    }

    protected $guarded = ['plantation_id'];
    protected $primaryKey = 'plantation_id';
}
