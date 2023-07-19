<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species_group extends Model
{
    use HasFactory;

    //Relationships
    public function journals()
    {
        return $this->belongsTo(Journal::class, 'resjournal_id');
    }
    public function species_record()
    {
        return $this->belongsTo(SpeciesRecord::class, 'species_id');
    }
    public function plantation()
    {
        return $this->belongsTo(Plantation::class, 'plantation_id');
    }

    protected $fillable = [
        'species_id',
        'resjournal_id'
    ];
}
