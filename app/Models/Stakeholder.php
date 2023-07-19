<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Stakeholder extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['org_name'] = $this->org_name;

        return $array;
    }
    public function mangrove_projects()
    {
        return $this->hasMany(MangroveProject::class, 'stakeholder_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'stakeholder_id',
        'stakeholder_type',
        'stakeholder_name',
        'stakeholder_email',
        'contact_num',
        'org_name',
        'endorsement_letter',
        'status',
    ];

    public function getFillable()
    {
        return $this->fillable;
    }

    public function endorsement_letters()
    {
        return $this->hasMany(Attachments::class, 'file_id');
    }

    protected $guarded = ['stakeholder_id'];
    protected $primaryKey = 'stakeholder_id';
}