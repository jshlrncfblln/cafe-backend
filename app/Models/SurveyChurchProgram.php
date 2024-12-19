<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyChurchProgram extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'survey_id',
        'church_program_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function churchPrograms()
    {
        return $this->belongsTo(ChurchPrograms::class, 'church_program_id');
    }
}
