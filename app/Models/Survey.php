<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'fathers_firstname',
        'fathers_middlename',
        'fathers_lastname',
        'mothers_firstname',
        'mothers_middlename',
        'mothers_lastname',
        'fathers_birthdate',
        'mothers_birthdate',
        'fathers_occupation',
        'mothers_occupation',
        'address',
        'fathers_contact_number',
        'mothers_contact_number',
        'marriage_type',
        'years_married',
        'family_income',
    ];

    public function children()
    {
        return $this->hasMany(Childrens::class);
    }

    // Shortcut to related Organizations
    public function organizations()
    {
        return $this->hasManyThrough(
            Organizations::class,
            SurveyOrganization::class,
            'survey_id',       // Foreign key on SurveyOrganization table
            'id',              // Foreign key on Organizations table
            'id',              // Local key on Survey table
            'organization_id'  // Local key on SurveyOrganization table
        );
    }

    public function surveylivelihoods()
    {
        return $this->hasMany(SurveyLivelihood::class);
    }

    public function surveyOrganizations()
    {
        return $this->hasMany(SurveyOrganization::class);
    }

    public function surveyChurchPrograms() {
        return $this->hasMany(SurveyChurchProgram::class);
    }
}
