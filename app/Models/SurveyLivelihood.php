<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyLivelihood extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'survey_id',
        'livelihood_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function livelihoodProgram()
    {
        return $this->belongsTo(LivelihoodPrograms::class, 'livelihood_id');
    }
}
