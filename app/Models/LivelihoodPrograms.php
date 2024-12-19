<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LivelihoodPrograms extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'livelihood_programs';

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

    public function surveys() {
        return $this->hasManyThrough(
            Survey::class,
            SurveyLivelihood::class,
            'livelihood_program_id',
            'id',
            'id',
            'survey_id'
        );
    }

    public function surveyLivelihoods() {
        return $this->hasMany(SurveyLivelihood::class, 'livelihood_program_id');
    }
}