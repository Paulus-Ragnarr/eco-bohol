<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Journal extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();
 
        // Customize the data array...
        $array['resjournal_id'] = $this->resjournal_id;
        $array['title'] = $this->title;
        $array['status'] = $this->status;
        $array['author'] = $this->author;
        $array['publisher'] = $this->publisher;

        return $array;
    }

    // Relationships
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function species_record() {
        return $this->belongsTo(SpeciesRecord::class, 'species_id');
    }

    protected $fillable = ['title', 'author', 'publisher', 'date_published', 
                            'status', 'user_id', 'species_id',];
                            
    public function getFillable()
    {
        return $this->fillable;
    }

    public function journal_images(){
        return $this->hasMany(Images::class, 'resjournal_id');
    }

    public function journal_file(){
        return $this->hasMany(Attachments::class, 'file_id');
    }
    public function species_groups(){
        return $this->hasMany(Species_group::class, 'resjournal_id');
    }
    protected $guarded = "resjournal_id";
    protected $primaryKey = "resjournal_id";
}
