<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Childrens extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'survey_id',
        'name',
        'birthdate',
        'employement_status',
        'received',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
