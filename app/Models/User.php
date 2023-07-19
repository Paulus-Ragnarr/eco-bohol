<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_contact',
        'user_role',
        'position',
        'status',
        'office'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $primaryKey = "user_id";

    // Relationships    
    public function journals()
    {
        return $this->hasMany(Journal::class, "user_id");
    }
    public function species_records()
    {
        return $this->hasMany(SpeciesRecord::class, "user_id");
    }
    public function officer_monitorings()
    {
        return $this->hasMany(OfficerMonitoring::class, 'user_id');
    }
    public function manager()
    {
        return $this->hasOne(Manager::class, 'manager_id');
    }
    public function stakeholder()
    {
        return $this->hasOne(Stakeholder::class, 'stakeholder_id');
    }
    public function permissions()
    {
        if ($this->user_role == 'admin') {
            $return_array = [
                'species_records' => true,
                'manage_journals' => false,
                'mangrove_projects' => false,
                'plantations' => true,
                'nurseries' => false,
                'manage_maps' => true,
                'reports' => true,
                'report-nursery' => true,
                'heatmap_reports' => true,
                'plantation_record_report' => true,
                'monitoring_report' => true,
                'nursery_record_report' => true,
                'nursery_monitor_report' => false,
                'project_reports' => false,
                'manage_accounts' => true,
                'stakeholders' => true,
            ];
        } else if ($this->user_role == 'manager') {
            $return_array = [
                'species_records' => false,
                'manage_journals' => false,
                'mangrove_projects' => false,
                'plantations' => true,
                'nurseries' => true,
                'manage_maps' => true,
                'reports' => true,
                'report-nursery' => true,
                'heatmap_reports' => true,
                'manage_accounts' => false,
                'plantation_record_report' => false,
                'nursery_record_report' => false,
                'nursery_monitor_report' => true,
                'monitoring_report' => true,
                'project_reports' => false,
                'stakeholders' => false,
            ];
        } else if ($this->user_role == 'officer') {
            $return_array = [
                'species_records' => false,
                'manage_journals' => false,
                'mangrove_projects' => false,
                'plantations' => true,
                'nurseries' => false,
                'manage_maps' => true,
                'reports' => true,
                'report-nursery' => true,
                'heatmap_reports' => true,
                'plantation_record_report' => true,
                'monitoring_report' => true,
                'nursery_record_report' => false,
                'nursery_monitor_report' => false,
                'manage_accounts' => false,
                'project_reports' => false,
                'stakeholders' => false,
            ];
        } else if ($this->user_role == 'researcher') {
            $return_array = [
                'species_records' => false,
                'manage_journals' => true,
                'mangrove_projects' => false,
                'plantations' => false,
                'nurseries' => false,
                'manage_maps' => true,
                'reports' => false,
                'report-nursery' => false,
                'heatmap_reports' => false,
                'plantation_record_report' => false,
                'monitoring_report' => false,
                'nursery_record_report' => false,
                'nursery_monitor_report' => false,
                'project_reports' => false,
                'manage_accounts' => false,
                'stakeholders' => false,
            ];
        } else if ($this->user_role == 'stakeholder') {
            $return_array = [
                'species_records' => false,
                'manage_journals' => false,
                'mangrove_projects' => true,
                'plantations' => false,
                'nurseries' => false,
                'manage_maps' => true,
                'report-nursery' => false,
                'reports' => true,
                'heatmap_reports' => true,
                'plantation_record_report' => false,
                'monitoring_report' => false,
                'nursery_record_report' => false,
                'nursery_monitor_report' => false,
                'project_reports' => true,
                'manage_accounts' => false,
                'stakeholders' => false,
            ];
        } else {
            $return_array = [
                'species_records' => false,
                'mangrove_projects' => false,
                'plantations' => false,
                'nurseries' => false,
                'manage_maps' => false,
                'reports' => false,
                'report-nursery' => false,
                'heatmap_reports' => false,
                'plantation_record_report' => false,
                'monitoring_report' => false,
                'nursery_record_report' => false,
                'nursery_monitor_report' => false,
                'project_reports' => false,
                'manage_accounts' => false,
                'stakeholders' => false,
            ];
        }
        return $return_array;
    }
}