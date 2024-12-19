<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyOrganization extends Model
{
    public $timestamps = false;
    //
    protected $fillable = [
        'survey_id',
        'organization_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organizations::class, 'organization_id');
    }
}
