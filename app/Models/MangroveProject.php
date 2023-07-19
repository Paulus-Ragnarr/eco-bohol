<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class MangroveProject extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize the data array...
        // $array['project_id'] = $this->project_id;
        $array['project_title'] = $this->project_title;
        $array['proj_status'] = $this->proj_status;
        $array['beneficiaries'] = $this->beneficiaries;
        $array['status'] = $this->status;
        $array['stakeholder_id'] = $this->stakeholder_id;

        return $array;
    }

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    protected $fillable = [
        'project_id',
        'project_title',
        'project_descrp',
        'project_img',
        'date_started',
        'beneficiaries',
        'date_end',
        'project_attachment',
        'proj_status',
        'status',
        'stakeholder_id'
    ];

    public function getFillable()
    {
        return $this->fillable;
    }

    public function project_images()
    {
        return $this->hasMany(Images::class, 'project_id');
    }

    public function project_attachments()
    {
        return $this->hasMany(Attachments::class, 'file_id');
    }


    protected $guarded = ['project_id'];
    protected $primaryKey = 'project_id';
}