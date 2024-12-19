<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizations extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with SurveyOrganization
    public function surveyOrganizations()
    {
        return $this->hasMany(SurveyOrganization::class, 'organization_id');
    }

    // Shortcut to related Surveys
    public function surveys()
    {
        return $this->hasManyThrough(
            Survey::class,
            SurveyOrganization::class,
            'organization_id', // Foreign key on SurveyOrganization table
            'id',              // Foreign key on Survey table
            'id',              // Local key on Organizations table
            'survey_id'        // Local key on SurveyOrganization table
        );
    }
}