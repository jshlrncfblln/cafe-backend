<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChurchPrograms extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];
    public function surveys()
    {
        return $this->hasManyThrough(
            Survey::class,
            SurveyChurchProgram::class,
            'church_program_id',
            'id',
            'id',
            'survey_id'
        );
    }

    public function surveyChurchPrograms()
    {
        return $this->hasMany(SurveyChurchProgram::class, 'church_program_id');
    }
}
